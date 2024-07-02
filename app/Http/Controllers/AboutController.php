<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::all();
        return view('pages.about.about', ['abouts' => $abouts, 'isEmpty' => $abouts->isEmpty()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);
        $imagePath = $request->file('image')->store('product_image', 'public');
        $image = Image::make(Storage::disk('public')->path($imagePath));
        $image->resize(200, 200)->save();

        $about = About::create([
            'content' => $validatedData['content'],
            'image' => $imagePath
        ]);

        if ($about) {
            return redirect()->route('about.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('about.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $about = About::find($id);

        if ($about) {
            return view('pages.about.about-edit', compact('about'));
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $about = About::find($id);
        if ($about) {
            $dataToUpdate = [
                'content' => $validatedData['content'],
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($about->image) {
                    Storage::disk('public')->delete($about->image);
                }
                // Store new image and resize
                $imagePath = $request->file('image')->store('product_image', 'public');
                $image = Image::make(Storage::disk('public')->path($imagePath));
                //$image->resize(1080, 1351)->save(); // Adjust size as needed
                $dataToUpdate['image'] = $imagePath;
            }
            $about->update($dataToUpdate);
            return redirect()->route('about.index')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('about.index')->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $about = about::findOrFail($id);

        // Delete the image
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();
        return redirect()->route('about.index')->with('success', 'Data berhasil dihapus');
    }
}
