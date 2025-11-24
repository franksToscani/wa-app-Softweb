<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    public function store(Request $request): RedirectResponse
    {
        // Log an incoming registration attempt (do NOT log passwords)
        Log::info('Registration attempt', [
            'ip' => $request->ip(),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
        ]);

        try {
            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            Log::info('Registration successful', [
                'id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);

            return redirect(route('dashboard', absolute: false));
        } catch (\Throwable $e) {
            // Log the failure for debugging (don't include request body with password)
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'exception' => get_class($e),
                'ip' => $request->ip(),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
            ]);

            throw $e;
        }
    }
}
