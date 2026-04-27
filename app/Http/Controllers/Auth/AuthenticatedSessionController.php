<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }


    /**
     * Handle an incoming authentication request.
     */
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // 1. Prioritaskan pengecekan Role Calon Mahasiswa (PMB)
        if ($user->hasRole('Calon Mahasiswa')) {
            return redirect()->intended('/pmb/dashboard');
        }

        // 2. Prioritaskan pengecekan Role Mahasiswa Aktif
        if ($user->hasRole('Mahasiswa')) {
            return redirect()->intended('/mahasiswa/dashboard');
        }

        // 3. Prioritaskan pengecekan Role Dosen
        if ($user->hasRole('Dosen')) {
            return redirect()->intended('/dosen/dashboard'); 
        }

        // 4. Terakhir, cek untuk Staff/Admin Panel (Filament)
        if ($user->can('akses_admin_panel')) {
            return redirect()->intended('/admin'); 
        }

        // Fallback default jika tidak punya role (keamanan tambahan)
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->withErrors(['email' => 'Akun Anda tidak memiliki akses ke portal manapun.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
