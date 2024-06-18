<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $action = $request->path() === 'register' ? 'register' : 'login';
        return view('pages.auth.index', compact('action'));
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => 2,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard'); // Adjust the redirection as needed
    }

    public function loginAction(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt untuk login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerasi session untuk menghindari fixation attacks

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect ke halaman dashboard
            return redirect()->intended('dashboard');
        }

        // Login sebagai admin
        // $request->session()->regenerate();
        // if (Auth::user()->role_id == 1) {
        //     return redirect('dashboard');
        // }

        // Login sebagai penjual
        // if (Auth::user()->role_id == 2) {
        //     return redirect('profile');
        // }

        // Jika login gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'Upss, login gagal. Silakan periksa email dan kata sandi Anda.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
