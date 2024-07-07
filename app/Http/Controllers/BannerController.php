<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('pages.banner.banner', ['banners' => $banners]);
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'type' => 'required|in:head,slideshow', // Memastikan jenis banner sesuai dengan pilihan
        ]);
        $imagePath = $request->file('image')->store('banner_image', 'public');
        $image = Image::make(Storage::disk('public')->path($imagePath));
        if ($validatedData['type'] === 'head') {
            // Resize gambar jika type adalah 'head'
            $image->resize(1080, 900, function ($constraint) {
                $constraint->aspectRatio();
            });
        } elseif ($validatedData['type'] === 'slideshow') {
            // Resize gambar jika type adalah 'slideshow'
            $image->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        // Simpan gambar yang sudah diresize
        $image->save();

        $banner = Banner::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'type' => $validatedData['type'],
        ]);

        if ($banner) {
            return redirect()->route('banner.index')->with('success', 'Banner berhasil ditambahkan');
        } else {
            return redirect()->route('banner.index')->with('error', 'Banner gagal ditambahkan');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $banner = Banner::find($id);

        if ($banner) {
            return view('pages.banner.banner-edit', compact('banner'));
        } else {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'type' => 'required|in:head,slideshow', // Memastikan jenis banner sesuai dengan pilihan
        ]);
        $banner = Banner::find($id);
        if ($banner) {
            $dataToUpdate = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'type' => $validatedData['type'],
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($banner->image) {
                    Storage::disk('public')->delete($banner->image);
                }
                // Store new image and resize
                $imagePath = $request->file('image')->store('banner_image', 'public');
                $image = Image::make(Storage::disk('public')->path($imagePath));
                //$image->resize(1080, 1351)->save(); // Adjust size as needed
                $dataToUpdate['image'] = $imagePath;
            }
            $banner->update($dataToUpdate);
            return redirect()->route('banner.index')->with('success', 'Banner berhasil diupdate');
        } else {
            return redirect()->route('banner.index')->with('error', 'Banner tidak ditemukan');
        }
    }
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete the image
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();
        return redirect()->route('banner.index')->with('success', 'Banner berhasil dihapus');
    }
}
