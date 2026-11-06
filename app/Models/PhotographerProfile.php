<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotographerProfile extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'bio', 'location', 'specialization',
        'price_per_hour', 'years_of_experience', 'is_available',
    ];

    protected $casts = [
        'is_available'   => 'boolean',
        'price_per_hour' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function portfolio() {
        return $this->hasOne(Portfolio::class);
    }

    // Average rating helper
    public function averageRating(): float {
        return $this->user
            ->reviewsReceived()
            ->avg('rating') ?? 0;
    }
    public function packages() {
    return $this->hasMany(PhotographerPackage::class);
}

public function activePackages() {
    return $this->hasMany(PhotographerPackage::class)->where('is_active', true);
}
}