<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\User;
use App\Models\UserMistake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        if ($user) {
            return view('pages.users.showActive', compact('user'));
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

        if ($user) {
            return view('pages.users.showReject', compact('user'));
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

        if ($user) {
            return view('pages.users.showInactive', compact('user'));
        } else {
            return redirect()->route('users.inactive')->with('error', 'User tidak ditemukan');
        }
    }

    public function update($id)
    {

        $user = User::find($id);

        if ($user) {
            if($user->status == "inactive"){
            $dataToUpdate = [
                'status' => 'active',
            ];

            $user->update($dataToUpdate);

            return redirect()->route('users.active')->with('success', 'User berhasil diapprove');
            }else{
                $dataToUpdate = [
                    'status' => 'inactive',
                ];

            $user->update($dataToUpdate);

            return redirect()->route('users.inactive')->with('success', 'User berhasil diUnapprove');
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

            if($user->status == "inactive" || $user->status == "active"){
                // Save the user mistake
                UserMistake::create([
                    'user_id' => $user->id,
                    'curentStatus' => $user->status,
                    'description' => $request->description,
                ]);

                // Update user status to declined
                $user->update(['status' => 'declined']);

                return redirect()->route('users.showReject')->with('success', 'Pengguna Berhasil Diblok');
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
                return redirect()->route('users.showReject')->with('error', 'Pengguna tidak dalam status declined');
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::find($id);

        if ($user) {
            $dataToUpdate = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
            ];

            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }

                // Store new photo
                $photoPath = $request->file('photo')->store('photo_users', 'public');
                $dataToUpdate['photo'] = $photoPath;
            }

            $user->update($dataToUpdate);

            return redirect()->route('users.profile')->with('success', 'User berhasil diupdate');
        } else {
            return redirect()->route('users.profile')->with('error', 'User tidak ditemukan');
        }
    }
}
