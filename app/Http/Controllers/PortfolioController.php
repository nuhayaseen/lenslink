<?php
namespace App\Http\Controllers;

use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller {

    public function index() {
        $profile   = auth()->user()->photographerProfile;
        $portfolio = $profile->portfolio()->with('images')->first();
        return view('photographer.portfolio.index', compact('portfolio', 'profile'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
        ]);

        $profile = auth()->user()->photographerProfile;

        if ($profile->portfolio) {
            return back()->with('error', 'You already have a portfolio.');
        }

        $profile->portfolio()->create([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Portfolio created.');
    }

    public function update(Request $request) {
        $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
        ]);

        auth()->user()->photographerProfile->portfolio->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Portfolio updated.');
    }

    public function uploadImages(Request $request) {
        $request->validate([
            'images'     => 'required|array|max:10',
            'images.*'   => 'image|mimes:jpeg,png,webp|max:2048',
            'captions'   => 'nullable|array',
            'captions.*' => 'nullable|string|max:150',
        ]);

        $portfolio = auth()->user()->photographerProfile->portfolio;

        if (!$portfolio) {
            return back()->with('error', 'Create a portfolio first.');
        }

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('portfolios/' . auth()->id(), 'public');
            $portfolio->images()->create([
                'image_path' => $path,
                'caption'    => $request->captions[$index] ?? null,
            ]);
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    public function deleteImage(PortfolioImage $image) {
        $portfolioId = auth()->user()->photographerProfile->portfolio->id ?? null;
        abort_if($image->portfolio_id !== $portfolioId, 403);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
}