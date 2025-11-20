<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    public function requests()
    {
        return $this->hasMany(FoodRequest::class, 'beneficiary_id');
    }

    public function deliveryTasks()
    {
        return $this->hasMany(DeliveryTask::class, 'volunteer_id');
    }

    public function feedbackGiven()
    {
        return $this->hasMany(Feedback::class, 'from_user_id');
    }

    public function feedbackReceived()
    {
        return $this->hasMany(Feedback::class, 'to_user_id');
    }

    public function notifications()
    {
        return $this->hasMany(SystemNotification::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'admin_id');
    }
}
