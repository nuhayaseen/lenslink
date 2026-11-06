<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function dashboard() {
        $stats = [
            'total_users'        => User::count(),
            'photographers'      => User::where('role', 'photographer')->count(),
            'clients'            => User::where('role', 'client')->count(),
            'total_bookings'     => Booking::count(),
            'pending_bookings'   => Booking::where('status', 'pending')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'revenue'            => Payment::where('payment_status', 'paid')->sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request) {
        $query = User::query();
        if ($request->role) {
            $query->where('role', $request->role);
        }
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUser(User $user) {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'User status updated.');
    }

    public function deleteUser(User $user) {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function bookings(Request $request) {
        $query = Booking::with('client', 'photographer', 'package');
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $bookings = $query->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function photographers() {
        $photographers = User::where('role', 'photographer')
                             ->with('photographerProfile.portfolio')
                             ->withCount('bookingsAsPhotographer')
                             ->paginate(10);

        return view('admin.photographers.index', compact('photographers'));
    }



    public function index() {
        $templates = PackageTemplate::withCount('packages')->latest()->get();
        return view('admin.packages.index', compact('templates'));
    }

    public function create() {
        return view('admin.packages.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'                => 'required|string|max:100',
            'description'         => 'nullable|string|max:500',
            'base_price'          => 'required|numeric|min:0',
            'base_duration_hours' => 'required|integer|min:1',
            'base_edited_photos'  => 'required|integer|min:0',
        ]);

        PackageTemplate::create([
            'name'                => $request->name,
            'description'         => $request->description,
            'base_price'          => $request->base_price,
            'base_duration_hours' => $request->base_duration_hours,
            'base_edited_photos'  => $request->base_edited_photos,
            'includes_raw'        => $request->boolean('includes_raw'),
            'includes_album'      => $request->boolean('includes_album'),
            'includes_video'      => $request->boolean('includes_video'),
            'is_active'           => true,
        ]);

        return redirect()->route('admin.packages.index')
                         ->with('success', 'Package template created successfully.');
    }

    public function edit(PackageTemplate $template) {
        return view('admin.packages.edit', compact('template'));
    }

    public function update(Request $request, PackageTemplate $template) {
        $request->validate([
            'name'                => 'required|string|max:100',
            'description'         => 'nullable|string|max:500',
            'base_price'          => 'required|numeric|min:0',
            'base_duration_hours' => 'required|integer|min:1',
            'base_edited_photos'  => 'required|integer|min:0',
        ]);

        $template->update([
            'name'                => $request->name,
            'description'         => $request->description,
            'base_price'          => $request->base_price,
            'base_duration_hours' => $request->base_duration_hours,
            'base_edited_photos'  => $request->base_edited_photos,
            'includes_raw'        => $request->boolean('includes_raw'),
            'includes_album'      => $request->boolean('includes_album'),
            'includes_video'      => $request->boolean('includes_video'),
        ]);

        return redirect()->route('admin.packages.index')
                         ->with('success', 'Package template updated.');
    }

    public function toggle(PackageTemplate $template) {
        $template->update(['is_active' => !$template->is_active]);
        return back()->with('success', 'Template status updated.');
    }

    public function destroy(PackageTemplate $template) {
        $template->delete();
        return back()->with('success', 'Template deleted.');
    }
}
