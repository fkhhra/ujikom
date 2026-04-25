<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['plate_number', 'type', 'branch_id', 'ownership'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function couriers()
    {
        return $this->hasMany(User::class, 'vehicle_id');
    }
}
