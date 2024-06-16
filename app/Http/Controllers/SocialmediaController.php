<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMedia;

class SocialmediaController extends Controller
{
    public function index()
    {
        $socialmedia= SocialMedia::all();
        return view('pages.dashboard.social-media',['sosmed'=>$socialmedia]);
    }
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'id'=> 'required|int',
            'whatsapp' => 'required|string|max:15',
            'facebook' => 'required|string|max:100',
            'instagram' => 'required|string|max:100',
            'tiktok'=> 'required|string|max:100'
        ]);
        $data = SocialMedia::create([
            'whatsapp' => $validateData['whatsapp'],
            'facebook' => $validateData['facebook'],
            'instagram' => $validateData['instagram'],
            'tiktok' => $validateData['tiktok'],
            'created_at' => now(),
            'update_at'=> now()
        ]);
        if($data){
            return redirect()->route('sosial-media');
        }
    }
}
