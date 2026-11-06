<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotographerPackage extends Model {
    use HasFactory;

    protected $fillable = [
        'photographer_profile_id',
        'name',
        'description',
        'price',
        'duration_hours',
        'edited_photos',
        'includes_raw',
        'includes_album',
        'includes_video',
        'is_active',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'includes_raw'  => 'boolean',
        'includes_album'=> 'boolean',
        'includes_video'=> 'boolean',
        'is_active'     => 'boolean',
    ];

    public function photographerProfile() {
        return $this->belongsTo(PhotographerProfile::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'package_id');
    }

    public function template() {
    return $this->belongsTo(PackageTemplate::class, 'template_id');
}
}