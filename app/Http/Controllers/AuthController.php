<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, arahkan ke halaman utama
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function postlogin(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login Successful',
                'redirect' => url('/')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Username atau password salah!',
            'msgField' => [
                'username' => ['Username atau password salah'],
                'password' => ['Silakan coba lagi']
            ]
        ]);
    }

    return redirect('login');

}


    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
