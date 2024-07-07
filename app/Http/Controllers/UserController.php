<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\User;
use App\Models\UserMistake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Other methods as per your existing implementation...

    public function showActive(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $user = User::find($id);
        $sosmed = SocialMedia::where('user_id', $user->id)->get();

        if ($user) {
            return view('pages.users.showActive', compact('user', 'sosmed'));
        } else {
            return redirect()->route('users.active')->with('error', 'User tidak ditemukan');
        }
    }

    public function showRejected(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $user = User::find($id);
        $sosmed = SocialMedia::where('user_id', $user->id)->get();

        if ($user) {
            return view('pages.users.showReject', compact('user', 'sosmed'));
        } else {
            return redirect()->route('users.active')->with('error', 'User tidak ditemukan');
        }
    }

    public function showInactive(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $user = User::find($id);
        $sosmed = SocialMedia::where('user_id', $user->id)->get();


        if ($user) {
            return view('pages.users.showInactive', compact('user', 'sosmed'));
        } else {
            return redirect()->route('users.inactive')->with('error', 'User tidak ditemukan');
        }
    }

    public function updateStatus($id)
    {

        $user = User::find($id);

        if ($user) {
            if ($user->status == "inactive") {
                $dataToUpdate = [
                    'status' => 'active',
                ];

                $user->update($dataToUpdate);

                return redirect()->route('users.active')->with('success', 'Pengguna berhasil diaktifkan');
            } else {
                $dataToUpdate = [
                    'status' => 'inactive',
                ];

                $user->update($dataToUpdate);

                return redirect()->route('users.inactive')->with('success', 'Pengguna berhasil dinonaktifkan');
            }
        } else {
            return redirect()->route('users.inactive')->with('error', 'User tidak ditemukan');
        }
    }

    public function active()
    {
        $users = User::where(['status' => 'active', 'role_id' => 2])->get();

        return view('pages.users.active', ['users' => $users]);
    }

    public function inactive()
    {
        $inactiveUsers = User::where(['status' => 'inactive', 'role_id' => 2])->get();
        return view('pages.users.inactive', ['inactiveUsers' => $inactiveUsers]);
    }

    public function showReject()
    {
        $rejectedUsers = User::where(['status' => 'declined', 'role_id' => 2])->get();
        return view('pages.users.rejected', ['rejectedUsers' => $rejectedUsers]);
    }

    public function actionReject(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $user = User::find($id);

        if ($user && $user->role_id == 2) {
            // Check if there's already a mistake record for this user
            $existingMistake = UserMistake::where('user_id', $user->id)->first();

            if ($existingMistake) {
                return redirect()->route('users.inactive')->with('error', 'Kesalahan untuk pengguna ini sudah dicatat sebelumnya');
            }

            if ($user->status == "inactive" || $user->status == "active") {
                // Save the user mistake
                UserMistake::create([
                    'user_id' => $user->id,
                    'curentStatus' => $user->status,
                    'description' => $request->description,
                ]);

                // Update user status to declined
                $user->update(['status' => 'declined']);

                return redirect()->route('users.showReject')->with('success', 'Pengguna berhasil ditangguhkan');
            }
        } else {
            return redirect()->route('users.inactive')->with('error', 'User tidak ditemukan atau tidak memiliki role yang sesuai');
        }
    }

    public function restore($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($user->status == "declined") {
                // Find all UserMistake entries for the user
                $userMistakes = UserMistake::where('user_id', $id)->get();

                if ($userMistakes->isEmpty()) {
                    return redirect()->route('users.showReject')->with('error', 'Tidak ada kesalahan yang dicatat untuk pengguna ini');
                }

                // Use the currentStatus from the first UserMistake entry to restore the user's status
                $currentStatus = $userMistakes->first()->curentStatus;

                // Update user's status
                $user->update(['status' => $currentStatus]);

                // Delete all UserMistake entries for this user
                UserMistake::where('user_id', $id)->delete();

                return redirect()->route('users.active')->with('success', 'Pengguna berhasil direstorasi');
            } else {
                return redirect()->route('users.showReject')->with('error', 'Pengguna tidak dalam status ditangguhkan');
            }
        } else {
            return redirect()->route('users.showReject')->with('error', 'User tidak ditemukan');
        }
    }

    public function profile()
    {
        $user = Auth::user();
        $sosmed = SocialMedia::where('user_id', $user->id)->get();
        return view('pages.profile.profile', compact('user', 'sosmed'));
    }

    public function updateProfile(Request $request, $id)
    {

        if ($request->has('whatsapp') && substr($request->whatsapp, 0, 1) === '0') {
            $request->merge(['whatsapp' => '62' . substr($request->whatsapp, 1)]);
        }
        // Validasi input pengguna
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/[0-9]{11,13}$/',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Validasi input media sosial
            'facebook' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        // Temukan pengguna berdasarkan ID
        $user = User::find($id);
        if (substr($request->phone, 0, 1) === '0') {
            $request->merge(['phone' => '62' . substr($request->phone, 1)]);
        }
        if ($user) {
            // Update data pengguna
            $dataToUpdate = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
            ];

            // Update foto pengguna jika ada
            if ($request->hasFile('photo')) {
                // Hapus foto lama
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }

                // Simpan foto baru
                $photoPath = $request->file('photo')->store('photo_users', 'public');
                $dataToUpdate['photo'] = $photoPath;
            }

            // Perbarui data pengguna
            $user->update($dataToUpdate);

            // Update atau buat data media sosial
            $sosmedData = [
                'facebook' => $validatedData['facebook'],
                'whatsapp' => $validatedData['whatsapp'],
                'tiktok' => $validatedData['tiktok'],
                'instagram' => $validatedData['instagram'],
            ];

            SocialMedia::updateOrCreate(
                ['user_id' => $user->id],
                $sosmedData
            );

            return redirect()->route('users.profile')->with('success', 'User berhasil diupdate');
        } else {
            return redirect()->route('users.profile')->with('error', 'User tidak ditemukan');
        }
    }
    public function updateUser(Request $request, $id)
    {

        if ($request->has('whatsapp') && substr($request->whatsapp, 0, 1) === '0') {
            $request->merge(['whatsapp' => '62' . substr($request->whatsapp, 1)]);
        }
        // Validasi input pengguna
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/[0-9]{11,13}$/',
            'support_document' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Validasi input media sosial
            'facebook' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        // Temukan pengguna berdasarkan ID
        $user = User::find($id);
        if (substr($request->phone, 0, 1) === '0') {
            $request->merge(['phone' => '62' . substr($request->phone, 1)]);
        }
        if ($user) {
            // Update data pengguna
            $dataToUpdate = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
            ];

            // Update foto pengguna jika ada
            if ($request->hasFile('support_document')) {
                // Hapus foto lama
                if ($user->support_document) {
                    Storage::disk('public')->delete($user->support_document);
                }

                // Simpan foto baru
                $photoPath = $request->file('support_document')->store('Document_users', 'public');
                $dataToUpdate['support_document'] = $photoPath;
            }

            // Perbarui data pengguna
            $user->update($dataToUpdate);

            // Update atau buat data media sosial
            $sosmedData = [
                'facebook' => $validatedData['facebook'],
                'whatsapp' => $validatedData['whatsapp'],
                'tiktok' => $validatedData['tiktok'],
                'instagram' => $validatedData['instagram'],
            ];

            SocialMedia::updateOrCreate(
                ['user_id' => $user->id],
                $sosmedData
            );

            return redirect()->route('users.active')->with('success', 'User berhasil diupdate');
        } else {
            return redirect()->route('users.active')->with('error', 'User tidak ditemukan');
        }
    }
    public function store(Request $request)
    {
        if (substr($request->phone, 0, 1) === '0') {
            $request->merge(['phone' => '62' . substr($request->phone, 1)]);
        }

        if ($request->has('whatsapp') && substr($request->whatsapp, 0, 1) === '0') {
            $request->merge(['whatsapp' => '62' . substr($request->whatsapp, 1)]);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'address' => 'required',

            'phone' => 'required|string|regex:/[0-9]{8,12}$/',
            'support_documents' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            // Validasi input media sosial
            'facebook' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
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
            'support_documents.required' => 'Dokumen pendukung harus ada',
        ]);

        if ($request->hasFile('support_documents')) {
            $file = $request->file('support_documents');
            $filename = $file->hashName();
            $path = $file->storeAs('Document_users', $filename, 'public');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'status' => 'active',
            'address' => $request->address,
            'role_id' => 2,
            'support_document' => $path ?? null, // Save filename in the database
        ]);


        // Simpan data sosial media
        $user->socialMedia()->create([
            'facebook' => $request->facebook,
            'whatsapp' => $request->whatsapp,
            'tiktok' => $request->tiktok,
            'instagram' => $request->instagram,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }
}
