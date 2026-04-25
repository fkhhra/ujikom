<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'tracking_number', 'sender_id', 'receiver_id', 'origin_branch_id',
        'destination_branch_id', 'current_branch_id', 'courier_id', 'rate_id', 
        'total_weight', 'total_price', 'payer_type', 'status', 'shipment_date', 'photo',
    ];

    protected function casts(): array
    {
        return ['shipment_date' => 'date'];
    }

    public function sender()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }

    public function originBranch()
    {
        return $this->belongsTo(Branch::class, 'origin_branch_id');
    }

    public function destinationBranch()
    {
        return $this->belongsTo(Branch::class, 'destination_branch_id');
    }

    public function currentBranch()
    {
        return $this->belongsTo(Branch::class, 'current_branch_id');
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function trackings()
    {
        return $this->hasMany(ShipmentTracking::class)->orderBy('tracked_at', 'asc');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'           => 'bg-yellow-100 text-yellow-800',
            'picked_up'         => 'bg-blue-100 text-blue-800',
            'in_transit'        => 'bg-indigo-100 text-indigo-800',
            'arrived_at_branch' => 'bg-purple-100 text-purple-800',
            'out_for_delivery'  => 'bg-orange-100 text-orange-800',
            'delivered'         => 'bg-green-100 text-green-800',
            'cancelled'         => 'bg-red-100 text-red-800',
            default             => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'           => 'Menunggu',
            'picked_up'         => 'Dijemput',
            'in_transit'        => 'Dalam Perjalanan',
            'arrived_at_branch' => 'Tiba di Cabang',
            'out_for_delivery'  => 'Sedang Diantar',
            'delivered'         => 'Terkirim',
        };
    }

    public function isCod(): bool
    {
        return $this->payer_type === 'receiver';
    }

    public static function generateTrackingNumber(): string
    {
        return 'KA' . strtoupper(uniqid()) . rand(100, 999);
    }
}
