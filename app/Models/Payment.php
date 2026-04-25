<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentBank;

class Payment extends Model
{
    protected $fillable = [
        'shipment_id', 'amount', 'payment_method', 'payment_status', 'payment_date',
        'midtrans_order_id', 'midtrans_transaction_id', 'midtrans_bank',
        'midtrans_biller_code', 'midtrans_va_number', 'midtrans_payment_code',
    ];

    protected function casts(): array
    {
        return ['payment_date' => 'date'];
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'paid'    => 'Lunas',
            'failed'  => 'Gagal',
            'pending' => 'Menunggu Pembayaran',
            'expired' => 'Kadaluarsa',
            default   => ucfirst($this->payment_status ?? ''),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'paid'    => 'bg-green-100 text-green-800',
            'failed'  => 'bg-red-100 text-red-800',
            default   => 'bg-yellow-100 text-yellow-800',
        };
    }

    public function getMethodLabelAttribute(): string
    {
        $bankDisplay = PaymentBank::getLabel($this->midtrans_bank);
        
        return match($this->payment_method) {
            'cash'      => 'Tunai',
            'transfer'  => "Transfer Bank ($bankDisplay)",
            'e-wallet'  => "E-Wallet ($bankDisplay)",
            'qris'      => 'QRIS',
            default     => ucfirst($this->payment_method ?? ''),
        };
    }
}
