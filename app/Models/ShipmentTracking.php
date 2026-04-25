<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    protected $fillable = ['shipment_id', 'branch_id', 'location', 'description', 'status', 'tracked_at'];

    protected function casts(): array
    {
        return ['tracked_at' => 'datetime'];
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function images()
    {
        return $this->hasMany(ShipmentTrackingImage::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'picked_up'         => 'Dijemput',
            'in_transit'        => 'Dalam Perjalanan',
            'arrived_at_branch' => 'Tiba di Cabang',
            'out_for_delivery'  => 'Sedang Diantar',
            'delivered'         => 'Terkirim',
            default             => ucfirst($this->status ?? ''),
        };
    }
}
