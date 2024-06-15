<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index(){
        $category = Category::all();
        return view('pages.dashboard.category',['category'=>$category]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|max:50',
        ]);
        
        $data = Category::create([
            'category' => $validatedData['category'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        if($data){
            return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan');
        }
    }
    public function edit(Request $request)
    {
        // Validasi bahwa id adalah integer
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $data = Category::find($id);
        return view('pages.dashboard.category-edit', compact('data'));

        if ($data) {
            return view('pages.dashboard.category-edit', compact('data'));
        } else {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id' => 'required|max:255',
            'category' => 'required|max:50',
        ]);

        $data = Category::find($id);

        if ($data) {
            $data->update($validatedData);
            return redirect()->route('kategori')->with('success', 'Kategori berhasil diupdate');
        } else {
            // Redirect dengan pesan error
            return redirect()->route('kategori')->with('error', 'Kategori tidak ditemukan');
        }
    }
    public function destroy($id)
    {
        $data = Category::findOrFail($id);
        $data->delete();            
        return redirect()->back()->with('Success', 'Data berhasil dihapus'); 
        
    }
}
