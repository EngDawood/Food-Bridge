<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'food_type',
        'quantity',
        'remaining_quantity',
        'expiration_date',
        'pickup_time',
        'status',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'pickup_time' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function requests()
    {
        return $this->hasMany(FoodRequest::class, 'donation_id');
    }

    public function deliveryTask()
    {
        return $this->hasOne(DeliveryTask::class, 'donation_id');
    }

    protected static function booted()
    {
        static::creating(function (Donation $donation) {
            if (is_null($donation->remaining_quantity)) {
                $donation->remaining_quantity = $donation->quantity;
            }
        });
    }
}


