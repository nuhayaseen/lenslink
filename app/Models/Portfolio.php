<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model {
    use HasFactory;

    protected $fillable = [
        'photographer_profile_id', 'title', 'description',
    ];

    public function photographerProfile() {
        return $this->belongsTo(PhotographerProfile::class);
    }

    public function images() {
        return $this->hasMany(PortfolioImage::class);
    }
}