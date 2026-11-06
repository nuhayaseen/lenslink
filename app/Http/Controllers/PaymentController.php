<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller {

    public function index(Request $request) {
        $query = Payment::with('booking.client', 'booking.photographer', 'booking.package')
                        ->latest();

        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('booking.client', fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            )->orWhereHas('booking.photographer', fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            );
        }

        $payments = $query->paginate(10);

        $stats = [
            'total'    => Payment::count(),
            'paid'     => Payment::where('payment_status', 'paid')->count(),
            'pending'  => Payment::where('payment_status', 'pending')->count(),
            'revenue'  => Payment::where('payment_status', 'paid')->sum('amount'),
            'pending_amount' => Payment::where('payment_status', 'pending')->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function markPaid(Request $request, Payment $payment) {
        $request->validate([
            'payment_note' => 'nullable|string|max:255',
        ]);

        $payment->update([
            'payment_status' => 'paid',
            'payment_note'   => $request->payment_note,
        ]);

        // Mark booking as completed if not already
        if (!$payment->booking->isCompleted()) {
            $payment->booking->update(['status' => 'completed']);
        }

        return back()->with('success', 'Payment marked as paid successfully.');
    }

    public function markPending(Payment $payment) {
        $payment->update([
            'payment_status' => 'pending',
            'payment_note'   => null,
        ]);

        return back()->with('success', 'Payment marked as pending.');
    }

    public function show(Payment $payment) {
        $payment->load('booking.client', 'booking.photographer', 'booking.package');
        return view('admin.payments.show', compact('payment'));
    }
    public function clientPayments() {
    $payments = Payment::with('booking.photographer', 'booking.package')
                       ->whereHas('booking', fn($q) =>
                           $q->where('client_id', auth()->id())
                       )
                       ->latest()
                       ->paginate(10);

    $stats = [
        'total'          => $payments->total(),
        'paid'           => Payment::whereHas('booking', fn($q) =>
                                $q->where('client_id', auth()->id())
                            )->where('payment_status', 'paid')->count(),
        'pending'        => Payment::whereHas('booking', fn($q) =>
                                $q->where('client_id', auth()->id())
                            )->where('payment_status', 'pending')->count(),
        'total_spent'    => Payment::whereHas('booking', fn($q) =>
                                $q->where('client_id', auth()->id())
                            )->where('payment_status', 'paid')->sum('amount'),
    ];

    return view('client.payments', compact('payments', 'stats'));
}

public function photographerPayments() {
    $payments = Payment::with('booking.client', 'booking.package')
                       ->whereHas('booking', fn($q) =>
                           $q->where('photographer_id', auth()->id())
                       )
                       ->latest()
                       ->paginate(10);

    $stats = [
        'total'          => $payments->total(),
        'paid'           => Payment::whereHas('booking', fn($q) =>
                                $q->where('photographer_id', auth()->id())
                            )->where('payment_status', 'paid')->count(),
        'pending'        => Payment::whereHas('booking', fn($q) =>
                                $q->where('photographer_id', auth()->id())
                            )->where('payment_status', 'pending')->count(),
        'total_earned'   => Payment::whereHas('booking', fn($q) =>
                                $q->where('photographer_id', auth()->id())
                            )->where('payment_status', 'paid')->sum('amount'),
    ];

    return view('photographer.payments', compact('payments', 'stats'));
}
}