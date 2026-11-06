<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PhotographerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotographerController extends Controller {

    public function dashboard() {
        $user = auth()->user();

        if (!$user->photographerProfile) {
            PhotographerProfile::create(['user_id' => $user->id]);
            $user->refresh();
        }

        $bookings = Booking::where('photographer_id', $user->id)
                           ->with('client', 'package')
                           ->latest()
                           ->paginate(10);

        $stats = [
            'total'      => Booking::where('photographer_id', $user->id)->count(),
            'pending'    => Booking::where('photographer_id', $user->id)->where('status', 'pending')->count(),
            'accepted'   => Booking::where('photographer_id', $user->id)->where('status', 'accepted')->count(),
            'completed'  => Booking::where('photographer_id', $user->id)->where('status', 'completed')->count(),
            'earnings'   => Booking::where('photographer_id', $user->id)
                                   ->where('status', 'completed')
                                   ->whereHas('payment', fn($q) => $q->where('payment_status', 'paid'))
                                   ->with('payment')
                                   ->get()
                                   ->sum(fn($b) => $b->payment->amount ?? 0),
            'avg_rating' => $user->reviewsReceived()->avg('rating') ?? 0,
        ];

        return view('photographer.dashboard', compact('stats', 'bookings'));
    }

    public function editProfile() {
        $user    = auth()->user();
        $profile = $user->photographerProfile;

        if (!$profile) {
            $profile = PhotographerProfile::create([
                'user_id' => $user->id,
            ]);
        }

        return view('photographer.profile.edit', compact('profile'));
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'bio'                 => 'nullable|string|max:1000',
            'location'            => 'nullable|string|max:100',
            'specialization'      => 'nullable|string|max:100',
            'price_per_hour'      => 'nullable|numeric|min:0',
            'years_of_experience' => 'nullable|integer|min:0',
            'profile_photo'       => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $user    = auth()->user();
        $profile = $user->photographerProfile;

        if (!$profile) {
            $profile = PhotographerProfile::create([
                'user_id' => $user->id,
            ]);
        }

        $profile->update([
            'bio'                 => $request->bio,
            'location'            => $request->location,
            'specialization'      => $request->specialization,
            'price_per_hour'      => $request->price_per_hour,
            'years_of_experience' => $request->years_of_experience,
            'is_available'        => $request->boolean('is_available'),
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')
                            ->store('profiles', 'public');
            $user->update(['profile_photo' => $path]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}