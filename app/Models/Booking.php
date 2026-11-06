<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use HasFactory;

    protected $fillable = [
        'client_id', 'photographer_id', 'event_type',
        'event_date', 'event_location', 'duration_hours',
        'budget', 'guest_count', 'additional_notes',
        'status', 'cancellation_reason',
    ];

    protected $casts = [
        'event_date' => 'date',
        'budget'     => 'decimal:2',
    ];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function photographer() {
        return $this->belongsTo(User::class, 'photographer_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function review() {
        return $this->hasOne(Review::class);
    }

    // Status helpers
    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isAccepted(): bool  { return $this->status === 'accepted'; }
    public function isCancelled(): bool { return $this->status === 'cancelled'; }
    public function isCompleted(): bool { return $this->status === 'completed'; }

    public function package() {
    return $this->belongsTo(PhotographerPackage::class, 'package_id');
}

    }