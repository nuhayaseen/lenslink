<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\PhotographerPackage;
use Illuminate\Http\Request;

class BookingController extends Controller {

    public function create(Request $request) {
        $photographer = User::where('role', 'photographer')
                            ->with('photographerProfile.activePackages')
                            ->findOrFail($request->photographer_id);

        $selectedPackage = null;
        if ($request->package_id) {
            $selectedPackage = PhotographerPackage::findOrFail($request->package_id);
        }

        return view('client.bookings.create', compact('photographer', 'selectedPackage'));
    }

    public function store(Request $request) {
        $request->validate([
            'photographer_id'  => 'required|exists:users,id',
            'package_id'       => 'nullable|exists:photographer_packages,id',
            'event_type'       => 'required|string|max:100',
            'event_date'       => 'required|date|after:today',
            'event_location'   => 'required|string|max:255',
            'duration_hours'   => 'required|integer|min:1',
            'budget'           => 'required|numeric|min:0',
            'guest_count'      => 'nullable|integer|min:1',
            'additional_notes' => 'nullable|string|max:1000',
        ]);

        $conflict = Booking::where('photographer_id', $request->photographer_id)
                           ->where('event_date', $request->event_date)
                           ->where('status', 'accepted')
                           ->exists();

        if ($conflict) {
            return back()->with('error', 'This photographer is not available on the selected date.');
        }

        Booking::create([
            'client_id'        => auth()->id(),
            'photographer_id'  => $request->photographer_id,
            'package_id'       => $request->package_id,
            'event_type'       => $request->event_type,
            'event_date'       => $request->event_date,
            'event_location'   => $request->event_location,
            'duration_hours'   => $request->duration_hours,
            'budget'           => $request->budget,
            'guest_count'      => $request->guest_count,
            'additional_notes' => $request->additional_notes,
            'status'           => 'pending',
        ]);

        return redirect()->route('client.bookings')
                         ->with('success', 'Booking request sent! Waiting for photographer response.');
    }

    public function accept(Booking $booking) {
        abort_if($booking->photographer_id !== auth()->id(), 403);
        abort_if(!$booking->isPending(), 403);

        $booking->update(['status' => 'accepted']);

        Payment::create([
            'booking_id'     => $booking->id,
            'amount'         => $booking->budget,
            'payment_status' => 'pending',
        ]);

        return back()->with('success', 'Booking accepted successfully.');
    }

    public function cancel(Request $request, Booking $booking) {
        abort_if($booking->photographer_id !== auth()->id(), 403);
        abort_if(!$booking->isPending(), 403);

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return back()->with('success', 'Booking cancelled.');
    }

    public function clientCancel(Booking $booking) {
        abort_if($booking->client_id !== auth()->id(), 403);
        abort_if(!$booking->isPending(), 403);

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Your booking has been cancelled.');
    }

    public function complete(Booking $booking) {
        abort_if($booking->photographer_id !== auth()->id(), 403);
        abort_if(!$booking->isAccepted(), 403);

        $booking->update(['status' => 'completed']);
        return back()->with('success', 'Booking marked as completed.');
    }
}