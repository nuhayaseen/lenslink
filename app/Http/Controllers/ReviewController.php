<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {

    public function store(Request $request, Booking $booking) {
        abort_if($booking->client_id !== auth()->id(), 403);
        abort_if(!$booking->isCompleted(), 403);
        abort_if($booking->review !== null, 403);

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'booking_id'      => $booking->id,
            'client_id'       => auth()->id(),
            'photographer_id' => $booking->photographer_id,
            'rating'          => $request->rating,
            'comment'         => $request->comment,
        ]);

        return back()->with('success', 'Review submitted. Thank you!');
    }
}