<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $action = $request->path() === 'register' ? 'register' : 'login';
        Session::put('action', $action);  // Set session action
        return view('pages.auth.index', compact('action'));
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'phone' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi',
            'name.min' => 'Nama minimal 3 huruf',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata Sandi harus diisi',
            'password.min' => 'Kata Sandi minimal 8 huruf',
            'password.confirmed' => 'Kata Sandi dan Konfirmasi Kata Sandi tidak cocok',
            'password_confirmation.required' => 'Konfirmasi Kata Sandi harus diisi',
            'password_confirmation.min' => 'Konfirmasi Kata Sandi minimal 8 huruf',
            'phone.required' => 'Telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => 2,
        ]);

        Session::flash('status', 'success');
        $message = 'Register Success <i class="bi bi-check-circle-fill"></i> Wait admin for approval !';
        Session::flash('message', new HtmlString($message));
        Session::put('action', 'register');  // Set session action
        return redirect()->route('register'); // Adjust the redirection as needed
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
            if (Auth::user()->status != "active") {

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                Session::flash('status-login', 'failed');
                Session::flash('message', 'Your account is not active yet. please contact admin!');
                return redirect('/login');
            }

            $request->session()->regenerate();
            if (Auth::user()->role_id == 1) {
                return redirect('dashboard');
            }

            if (Auth::user()->role_id == 2) {
                return redirect('dashboard');
            }
        }
        // Jika login gagal, kembalikan dengan pesan error
        Session::put('action', 'login');  // Set session action
        return back()->withErrors([
            'email-login' => 'login gagal. Silakan periksa email dan kata sandi Anda.',
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
