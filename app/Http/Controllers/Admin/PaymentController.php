<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['shipment.sender', 'shipment.receiver', 'shipment.originBranch', 'shipment.destinationBranch']);
    
        if (Auth::user()->role === 'manager') {
            $query->whereHas('shipment', function($q) {
                $q->where('origin_branch_id', Auth::user()->branch_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('shipment', function($q) use ($request) {
                $q->where('tracking_number', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.payments.index', compact('payments'));
    }

    public function printReceipt(Payment $payment)
    {
        $shipment = $payment->shipment;
        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'items', 'payment']);
        
        $logoPath = public_path('images/logo_dark.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }

        $itemCount = $shipment->items->count() ?: 1;
        $dynamicHeight = 280 + ($itemCount * 20) + 40;
        
        $customPaper = array(0, 0, 164.4, $dynamicHeight);
        $pdf = Pdf::loadView('pdf.payment-receipt', compact('shipment', 'logoBase64'))
                  ->setPaper($customPaper);

        return $pdf->stream('Receipt_' . $shipment->tracking_number . '.pdf');
    }
}
