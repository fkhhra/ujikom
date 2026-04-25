<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private string $serverKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->baseUrl   = config('midtrans.is_production')
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    public function pay(Request $request, Shipment $shipment)
    {
        $customerId = Auth::guard('customer')->id();
        abort_unless($shipment->sender_id === $customerId && $shipment->payer_type === 'sender', 403);

        $request->validate([
            'payment_method' => 'required|in:qris,bca,bri,bni,bsi,mandiri,gopay',
        ]);

        $orderId = $shipment->tracking_number . '-' . time();
        $body = $this->buildMidtransBody($request->payment_method, $orderId, (int)$shipment->total_price, $shipment->sender);

        $response = Http::withBasicAuth($this->serverKey, '')
                        ->post($this->baseUrl . '/charge', $body);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal menghubungi layanan pembayaran.');
        }

        $result = $response->json();
        
        $vaNumber = $this->extractVaNumber($result);
        $billerCode = $result['biller_code'] ?? null;
        $paymentCode = $result['payment_code'] ?? null;
        
        if (isset($result['actions'])) {
            foreach ($result['actions'] as $action) {
                if ($action['name'] === 'generate-qr-code') {
                    $paymentCode = $action['url'];
                }
                if ($action['name'] === 'deeplink-redirect') {
                    $vaNumber = $action['url'];
                }
            }
        }

        $payment = Payment::updateOrCreate(
            ['shipment_id' => $shipment->id],
            [
                'amount'                   => $shipment->total_price,
                'payment_method'           => $request->payment_method === 'qris' ? 'qris' : (in_array($request->payment_method, ['gopay']) ? 'e-wallet' : 'transfer'),
                'payment_status'           => 'pending',
                'midtrans_order_id'        => $orderId,
                'midtrans_transaction_id'  => $result['transaction_id'] ?? null,
                'midtrans_bank'            => $request->payment_method,
                'midtrans_biller_code'     => $billerCode,
                'midtrans_va_number'       => $vaNumber,
                'midtrans_payment_code'    => $paymentCode,
            ]
        );

        return redirect()->route('customer.payments.checkout', $payment);
    }

    public function checkout(Payment $payment)
    {
        $customerId = Auth::guard('customer')->id();
        $isPayer = ($payment->shipment->sender_id === $customerId && $payment->shipment->payer_type === 'sender') ||
                   ($payment->shipment->receiver_id === $customerId && $payment->shipment->payer_type === 'receiver');
                   
        abort_unless($isPayer, 403);
        
        $payment->load('shipment');
        return view('customer.payments.checkout', compact('payment'));
    }

    public function downloadQris(Payment $payment)
    {
        $customerId = Auth::guard('customer')->id();
        $isPayer = ($payment->shipment->sender_id === $customerId && $payment->shipment->payer_type === 'sender') ||
                   ($payment->shipment->receiver_id === $customerId && $payment->shipment->payer_type === 'receiver');
                   
        abort_unless($isPayer, 403);
        abort_unless($payment->midtrans_payment_code, 404);

        try {
            $response = Http::get($payment->midtrans_payment_code);
            
            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengunduh kode QR.');
            }

            return response($response->body())
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="QRIS-'.$payment->shipment->tracking_number.'.png"');
        } catch (\Exception $e) {
            Log::error('QRIS Download failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunduh.');
        }
    }

    public function checkStatus(Payment $payment)
    {
        $customerId = Auth::guard('customer')->id();
        $isPayer = ($payment->shipment->sender_id === $customerId && $payment->shipment->payer_type === 'sender') ||
                   ($payment->shipment->receiver_id === $customerId && $payment->shipment->payer_type === 'receiver');
                   
        abort_unless($isPayer, 403);

        if ($payment->payment_status === 'pending' && $payment->midtrans_order_id) {
            try {
                $response = Http::withBasicAuth($this->serverKey, '')
                                ->get($this->baseUrl . '/' . $payment->midtrans_order_id . '/status');

                if ($response->successful()) {
                    $result = $response->json();
                    $status = $result['transaction_status'] ?? 'pending';

                    if (in_array($status, ['settlement', 'capture'])) {
                        $payment->update([
                            'payment_status' => 'paid',
                            'payment_date'   => now(),
                        ]);
                        
                        $payment->shipment->update(['status' => 'paid']);
                    } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
                        $payment->update(['payment_status' => 'failed']);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Status check failed: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => $payment->payment_status,
        ]);
    }

    private function buildMidtransBody(string $type, string $orderId, int $amount, $sender): array
    {
        $customerData = [
            'first_name' => $sender->name ?? 'Customer',
            'email'      => $sender->email ?? 'customer@kirimaja.id',
            'phone'      => $sender->phone ?? '08000000000',
        ];

        $base = [
            'transaction_details' => ['order_id' => $orderId, 'gross_amount' => $amount],
            'customer_details'    => $customerData,
        ];

        return match($type) {
            'qris'    => array_merge($base, ['payment_type' => 'qris', 'qris' => ['acquirer' => 'gopay']]),
            'gopay'   => array_merge($base, ['payment_type' => 'gopay']),
            'bca'     => array_merge($base, ['payment_type' => 'bank_transfer', 'bank_transfer' => ['bank' => 'bca']]),
            'bri'     => array_merge($base, ['payment_type' => 'bank_transfer', 'bank_transfer' => ['bank' => 'bri']]),
            'bni'     => array_merge($base, ['payment_type' => 'bank_transfer', 'bank_transfer' => ['bank' => 'bni']]),
            'bsi'     => array_merge($base, ['payment_type' => 'bank_transfer', 'bank_transfer' => ['bank' => 'bsi']]),
            'mandiri' => array_merge($base, ['payment_type' => 'echannel', 'echannel' => ['bill_info1' => 'KirimAja', 'bill_info2' => 'Payment']]),
            default   => $base,
        };
    }

    private function extractVaNumber(array $result): ?string
    {
        if (!empty($result['va_numbers'][0]['va_number'])) return $result['va_numbers'][0]['va_number'];
        if (!empty($result['permata_va_number'])) return $result['permata_va_number'];
        if (!empty($result['bill_key'])) return $result['bill_key'];
        return null;
    }
}
