<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhotographerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Show registration page
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function store(Request $request)
    {
        // ✅ VALIDATION
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],

            // IMPORTANT: role must come from form select
            'role' => ['required', 'in:client,photographer'],
        ]);

        // ✅ CREATE USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // ✅ FIRE REGISTERED EVENT
        event(new Registered($user));

        // ✅ LOGIN USER
        Auth::login($user);

        // 📸 IF PHOTOGRAPHER → CREATE PROFILE AUTOMATICALLY
        if ($user->role === 'photographer') {

            PhotographerProfile::create([
                'user_id' => $user->id,
                'studio_name' => $user->name . "'s Studio",
                'location' => null,
                'specialization' => null,
                'bio' => null,
                'profile_image' => null,
            ]);

            return redirect()->route('photographer.dashboard');
        }

        // 👤 DEFAULT CLIENT FLOW
        return redirect()->route('client.dashboard');
    }
}