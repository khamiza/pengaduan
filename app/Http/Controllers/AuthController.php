<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


   public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        if (Auth::user()->role == 'admin') {
            return redirect('/admin');
        }

        if (Auth::user()->role == 'kepsek') {
            return redirect()->route('kepsek.dashboard');
        }

        if (Auth::user()->role == 'siswa') {
            return redirect('/');
        }
    }

    return redirect('/')->with('error','Username atau password salah');
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }
    
}
