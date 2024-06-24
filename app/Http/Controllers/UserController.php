<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\User;
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
        $rejectedUsers = User::where(['status' => 'decined', 'role_id' => 2])->get();
        return view('pages.users.rejected', ['rejectedUsers' => $rejectedUsers]);
    }

    public function actionReject($id)
    {

        $user = User::find($id);

        if ($user) {
            if($user->status == "inactive" || $user->status == "active"){
            $dataToUpdate = [
                'status' => 'decined',
            ];

            $user->update($dataToUpdate);

            return redirect()->route('users.showReject')->with('success', 'Pengguna Berhasil Diblok');
            }
        } else {
            return redirect()->route('users.inactive')->with('error', 'User tidak ditemukan');
        }
    }
    public function restore($id)
    {

        $user = User::find($id);

        if ($user) {
            if($user->status == "decined"){
            $dataToUpdate = [
                'status' => 'active',
            ];

            $user->update($dataToUpdate);

            return redirect()->route('users.active')->with('success', 'Pengguna Berhasil Tidak Diblok');
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
