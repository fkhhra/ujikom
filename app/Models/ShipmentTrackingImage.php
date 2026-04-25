<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentTrackingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_tracking_id',
        'image_path',
    ];

    public function tracking()
    {
        return $this->belongsTo(ShipmentTracking::class, 'shipment_tracking_id');
    }
}
