<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyCustomerEmail;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'city', 'phone', 'photo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function shipmentsSent()
    {
        return $this->hasMany(Shipment::class, 'sender_id');
    }

    public function shipmentsReceived()
    {
        return $this->hasMany(Shipment::class, 'receiver_id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyCustomerEmail);
    }
}
