<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMistake;
use Illuminate\Http\Request;
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
            'phone' => 'required|string|regex:/[0-9]{11,13}$/',
            'support_documents' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
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
            'phone.regex' => 'Telepon harus dimulai dengan 62 dan terdiri dari 9 hingga 13 digit',
            'support_documents.required' => 'Dokumen pendukung harus ada',
        ]);

        // Handle file upload and save with hashed name
        if ($request->hasFile('support_documents')) {
            $file = $request->file('support_documents');
            $filename = $file->hashName();
            $path = $file->storeAs('Document_users', $filename, 'public');
        }
        if (substr($request->phone, 0, 1) === '0') {
            $request->merge(['phone' => '62' . substr($request->phone, 1)]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => 2,
            'support_document' => $path ?? null, // Save filename in the database
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
            $user = Auth::user();

            // Regenerasi session untuk menghindari fixation attacks
            if ($user->status != "active") {
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($user->status == "declined") {
                    // Retrieve the user mistake description
                    $userMistake = UserMistake::where('user_id', $user->id)->first();
                    $errorMessage = 'Akun anda di tangguhkan karena "' . $userMistake->description . '"';

                    Session::flash('status-login', 'failed');
                    Session::flash('message', $errorMessage);
                } else {
                    Session::flash('status-login', 'failed');
                    Session::flash('message', 'Your account is not active yet. please contact admin!');
                }

                return redirect('/login');
            }

            $request->session()->regenerate();
            if ($user->role_id == 1 || $user->role_id == 2) {
                return redirect('dashboard');
            }
        }

        // Jika login gagal, kembalikan dengan pesan error
        Session::put('action', 'login'); // Set session action
        return back()->withErrors([
            'email-login' => 'Login gagal. Silakan periksa email dan kata sandi Anda.',
        ])->withInput($request->except('password'));
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
