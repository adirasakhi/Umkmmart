<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialmediaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userHasSosmedData = SocialMedia::where('user_id', $user->id)->exists();
        if ($user->role_id == 1) {
            $socialmedia = SocialMedia::all();
        } else {
            $socialmedia = SocialMedia::where('user_id', $user->id)->get();
        }
        return view('pages.dashboard.social-media', ['sosmed' => $socialmedia, 'userHasSosmedData' => $userHasSosmedData]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $validateData = $request->validate([
            'whatsapp' => 'required|string|max:15',
            'facebook' => 'required|string|max:100',
            'instagram' => 'required|string|max:100',
            'tiktok' => 'required|string|max:100'
        ]);

        $data = SocialMedia::create([
            'whatsapp' => $validateData['whatsapp'],
            'facebook' => $validateData['facebook'],
            'instagram' => $validateData['instagram'],
            'tiktok' => $validateData['tiktok'],
            'user_id' => $user->id,
            'created_at' => now(),
            'update_at' => now()
        ]);
        if ($data) {
            return redirect()->route('sosial-media');
        } else {
            return redirect()->route('sosial-media')->with('error', 'Gagal menambahkan sosial media');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $id = $request->id;
        $data = SocialMedia::find($id);

        if ($data) {
            return view('pages.dashboard.sosial-media-edit', compact('data'));
        }
    }
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $validateData = $request->validate([
            'id' => 'required|max:255',
            'whatsapp' => 'required|max:15',
            'facebook' => 'required|max:255',
            'instagram' => 'required|max:255',
            'tiktok' => 'required|max:255'
        ]);

        $data = SocialMedia::find($id);

        if ($data) {
            $data->update([
                'whatsapp' => $validateData['whatsapp'],
                'facebook' => $validateData['facebook'],
                'instagram' => $validateData['instagram'],
                'tiktok' => $validateData['tiktok'],
                'user_id' => $user->id,
                'updated_at' => now()
            ]);
            return redirect()->route('sosial-media');
        } else {
            return redirect()->route('sosial-media');
        }
    }

    public function destroy($id)
    {
        $data = SocialMedia::findOrFail($id);
        $data->delete();
        return redirect()->back();
    }
}
