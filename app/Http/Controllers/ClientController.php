<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller {

    public function dashboard() {
        $user     = auth()->user();
        $bookings = $user->bookingsAsClient()->with('photographer', 'package')->latest()->get();

        $stats = [
            'total'     => $bookings->count(),
            'pending'   => $bookings->where('status', 'pending')->count(),
            'accepted'  => $bookings->where('status', 'accepted')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
        ];

        $recent = $bookings->take(5);
        return view('client.dashboard', compact('stats', 'recent'));
    }

    public function browsePhotographers(Request $request) {
        $query = User::where('role', 'photographer')
                     ->where('is_active', true)
                     ->with('photographerProfile.activePackages');

        if ($request->location) {
            $query->whereHas('photographerProfile', fn($q) =>
                $q->where('location', 'like', '%' . $request->location . '%')
            );
        }

        if ($request->specialization) {
            $query->whereHas('photographerProfile', fn($q) =>
                $q->where('specialization', 'like', '%' . $request->specialization . '%')
            );
        }

        if ($request->max_price) {
            $query->whereHas('photographerProfile', fn($q) =>
                $q->where('price_per_hour', '<=', $request->max_price)
            );
        }

        $photographers = $query->paginate(9);
        return view('client.photographers.index', compact('photographers'));
    }

    public function showPhotographer($id) {
        $photographer = User::where('role', 'photographer')
                            ->with([
                                'photographerProfile.portfolio.images',
                                'photographerProfile.activePackages',
                                'reviewsReceived.client',
                            ])
                            ->findOrFail($id);

        $avgRating = $photographer->reviewsReceived()->avg('rating') ?? 0;
        return view('client.photographers.show', compact('photographer', 'avgRating'));
    }

    public function myBookings() {
        $bookings = auth()->user()
                          ->bookingsAsClient()
                          ->with('photographer', 'package', 'review')
                          ->latest()
                          ->paginate(10);

        return view('client.bookings', compact('bookings'));
    }
}