<?php

namespace App\Http\Controllers\Pmb;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
Use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pendaftaran = Auth::user()->pendaftaran;

        return Inertia::render('PMB/Pengumuman/Index', [
            'pendaftaran' => $pendaftaran
        ]);
    }
}