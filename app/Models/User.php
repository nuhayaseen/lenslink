<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'profile_photo', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // Role helpers
    public function isAdmin(): bool        { return $this->role === 'admin'; }
    public function isPhotographer(): bool { return $this->role === 'photographer'; }
    public function isClient(): bool       { return $this->role === 'client'; }

    // Relationships
    public function photographerProfile() {
        return $this->hasOne(PhotographerProfile::class);
    }

    public function bookingsAsClient() {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function bookingsAsPhotographer() {
        return $this->hasMany(Booking::class, 'photographer_id');
    }

    public function reviewsGiven() {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function reviewsReceived() {
        return $this->hasMany(Review::class, 'photographer_id');
    }

    
}