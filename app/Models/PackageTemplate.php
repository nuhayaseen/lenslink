<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTemplate extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'base_duration_hours',
        'base_edited_photos',
        'includes_raw',
        'includes_album',
        'includes_video',
        'is_active',
    ];

    protected $casts = [
        'includes_raw'   => 'boolean',
        'includes_album' => 'boolean',
        'includes_video' => 'boolean',
        'is_active'      => 'boolean',
        'base_price'     => 'decimal:2',
    ];

    public function packages() {
        return $this->hasMany(PhotographerPackage::class, 'template_id');
    }
}