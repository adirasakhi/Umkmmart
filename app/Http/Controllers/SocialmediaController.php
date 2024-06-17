<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMedia;

class SocialmediaController extends Controller
{
    public function index()
    {
        $socialmedia = SocialMedia::all();
        return view('pages.dashboard.social-media', ['sosmed' => $socialmedia]);
    }

    public function store(Request $request)
    {
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
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if ($data) {
            return redirect()->route('sosial-media')->with('success', 'Sosial media berhasil ditambahkan');
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
        } else {
            return redirect()->route('sosial-media')->with('error', 'Sosial media tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'whatsapp' => 'required|max:15',
            'facebook' => 'required|max:255',
            'instagram' => 'required|max:255',
            'tiktok' => 'required|max:255'
        ]);

        $data = SocialMedia::find($id);

        if ($data) {
            $data->update($validateData);
            return redirect()->route('sosial-media')->with('success', 'Sosial media berhasil diperbarui');
        } else {
            return redirect()->route('sosial-media')->with('error', 'Sosial media tidak ditemukan');
        }
    }

    public function destroy($id)
    {
        $data = SocialMedia::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Sosial media berhasil dihapus');
    }
}
