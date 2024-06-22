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
    public function index()
    {
        $users = User::where(['status' => 'active', 'role_id' => 2])->get();
        return view('pages.users.user', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'social_media_id' => 'nullable|integer',
            'role_id' => 'required|integer',
        ]);

        $photoPath = $request->file('photo')->store('photo_users', 'public');

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'photo' => $photoPath,
            'social_media_id' => $validatedData['social_media_id'],
            'role_id' => $validatedData['role_id'],
        ]);

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } else {
            return redirect()->route('users.index')->with('error', 'Gagal menambahkan user');
        }
    }

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
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan');
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

            return redirect()->route('users.index')->with('success', 'User berhasil diapprove');
            }else{
                $dataToUpdate = [
                    'status' => 'inactive',
                ];

            $user->update($dataToUpdate);

            return redirect()->route('users.index')->with('success', 'User berhasil diUnapprove');
            }
        } else {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan');
        }
    }


    public function registered()
    {
        $registeredUser = User::where(['status' => 'inactive', 'role_id' => 2])->get();
        return view('pages.users.registered', ['registeredUser' => $registeredUser]);
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
            return redirect()->route('users.registered')->with('error', 'User tidak ditemukan');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus');
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
