<?php

namespace App\Http\Controllers;

use App\Models\PackageTemplate;
use Illuminate\Http\Request;

class AdminPackageController extends Controller
{
    public function index()
    {
        $templates = PackageTemplate::withCount('packages')->latest()->get();
        return view('admin.packages.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
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

    public function edit(PackageTemplate $template)
    {
        return view('admin.packages.edit', compact('template'));
    }

    public function update(Request $request, PackageTemplate $template)
    {
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

    public function toggle(PackageTemplate $template)
    {
        $template->update(['is_active' => !$template->is_active]);
        return back()->with('success', 'Template status updated.');
    }

    public function destroy(PackageTemplate $template)
    {
        $template->delete();
        return back()->with('success', 'Template deleted.');
    }
}