<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',     // huruf besar
                'regex:/[a-z]/',     // huruf kecil
                'regex:/[0-9]/',     // angka
                'regex:/[@$!%*#?&]/' // simbol
            ],
            'termsCheck' => ['accepted'],
        ], [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'termsCheck.accepted' => 'Anda harus menyetujui Ketentuan Layanan dan Kebijakan Privasi.',
        ]);


        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }
}
