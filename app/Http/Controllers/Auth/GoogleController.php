<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }



    public function handleGoogleCallback()
    {
        // Ambil user dari Google
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Simpan atau update user ke database
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'username'   => $googleUser->getName(),
                'google_id'  => $googleUser->getId(),
                'avatar'     => $googleUser->getAvatar(),
                'password'   => bcrypt(str()->random(24)), // Password random, tidak digunakan
                'role'       => 'user',
            ]
        );

        // Login user
        Auth::login($user, true);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Redirect ke halaman utama
        return redirect()->route('homepage')->with('success', 'Berhasil login dengan Google!');
    }
}
