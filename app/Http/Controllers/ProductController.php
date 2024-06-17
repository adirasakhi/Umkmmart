<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('pages.dashboard.product', ['products' => $products,'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|integer',
        ]);

        $imagePath = $request->file('image')->store('product_images', 'public');

        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'category_id' => $validatedData['category_id'],
            'seller_id' => 2,
        ]);

        if ($product) {
            return redirect()->route('products.index')->with('success', 'Product berhasil ditambahkan');
        } else {
            return redirect()->route('products.index')->with('error', 'Product gagal ditambahkan');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;
        $product = Product::find($id);
        $categories = Category::all();

        if ($product) {
            return view('pages.dashboard.product-edit', compact('product', 'categories'));
        } else {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|integer',
        ]);

        $product = Product::find($id);

        if ($product) {
            $dataToUpdate = [
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                // Store new image
                $imagePath = $request->file('image')->store('product_images', 'public');
                $dataToUpdate['image'] = $imagePath;
            }

            $product->update($dataToUpdate);

            return redirect()->route('products.index')->with('success', 'Product berhasil diupdate');
        } else {
            return redirect()->route('products.index')->with('error', 'Product tidak ditemukan');
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus');
    }

}
