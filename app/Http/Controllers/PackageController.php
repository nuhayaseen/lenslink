<?php
namespace App\Http\Controllers;

use App\Models\PhotographerPackage;
use Illuminate\Http\Request;

class PackageController extends Controller {

    public function index() {
        $packages = auth()->user()
                          ->photographerProfile
                          ->packages()
                          ->latest()
                          ->get();

        return view('photographer.packages.index', compact('packages'));
    }

    public function create() {
    $templates = \App\Models\PackageTemplate::where('is_active', true)->get();
    return view('photographer.packages.create', compact('templates'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'           => 'required|string|max:100',
            'description'    => 'nullable|string|max:500',
            'price'          => 'required|numeric|min:0',
            'duration_hours' => 'required|integer|min:1',
            'edited_photos'  => 'required|integer|min:0',
        ]);

        $profile = auth()->user()->photographerProfile;

        if ($profile->packages()->count() >= 5) {
            return back()->with('error', 'You can create a maximum of 5 packages.');
        }

        $profile->packages()->create([
            'name'           => $request->name,
            'description'    => $request->description,
            'price'          => $request->price,
            'duration_hours' => $request->duration_hours,
            'edited_photos'  => $request->edited_photos,
            'includes_raw'   => $request->boolean('includes_raw'),
            'includes_album' => $request->boolean('includes_album'),
            'includes_video' => $request->boolean('includes_video'),
        ]);

        return redirect()->route('photographer.packages.index')
                         ->with('success', 'Package created successfully.');
    }

    public function edit(PhotographerPackage $package) {
        $this->authorizePackage($package);
        return view('photographer.packages.edit', compact('package'));
    }

    public function update(Request $request, PhotographerPackage $package) {
        $this->authorizePackage($package);

        $request->validate([
            'name'           => 'required|string|max:100',
            'description'    => 'nullable|string|max:500',
            'price'          => 'required|numeric|min:0',
            'duration_hours' => 'required|integer|min:1',
            'edited_photos'  => 'required|integer|min:0',
        ]);

        $package->update([
            'name'           => $request->name,
            'description'    => $request->description,
            'price'          => $request->price,
            'duration_hours' => $request->duration_hours,
            'edited_photos'  => $request->edited_photos,
            'includes_raw'   => $request->boolean('includes_raw'),
            'includes_album' => $request->boolean('includes_album'),
            'includes_video' => $request->boolean('includes_video'),
        ]);

        return redirect()->route('photographer.packages.index')
                         ->with('success', 'Package updated successfully.');
    }

    public function toggle(PhotographerPackage $package) {
        $this->authorizePackage($package);
        $package->update(['is_active' => !$package->is_active]);
        return back()->with('success', 'Package status updated.');
    }

    public function destroy(PhotographerPackage $package) {
        $this->authorizePackage($package);
        $package->delete();
        return back()->with('success', 'Package deleted.');
    }

    private function authorizePackage(PhotographerPackage $package) {
        $profileId = auth()->user()->photographerProfile->id;
        abort_if($package->photographer_profile_id !== $profileId, 403);
    }
}