<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $user = null;
        if (Auth::user()->role_id == 1) {
            $user = User::where('role_id', '!=', 1)->get();
            $products = Product::all();
        } else {
            $user = Auth::user();
            $products = Product::where('seller_id', $user->id)->get();
        }
        $categories = Category::all();
        return view('pages.product.product', ['products' => $products, 'categories' => $categories, 'user' => $user]);
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|integer',
            'seller_id' => 'required_if:role_id,1|integer',
        ]);

        $imagePath = $request->file('image')->store('product_image', 'public');
        $image = Image::make(Storage::disk('public')->path($imagePath));
        $image->resize(1080, 1351)->save();

        $sellerId = ($user->role_id == 2) ? $user->id : $validatedData['seller_id'];
        $price = str_replace('.', '', $request->post('price'));

        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $price,
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'category_id' => $validatedData['category_id'],
            'seller_id' => $sellerId,
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
            return view('pages.product.product-edit', compact('product', 'categories'));
        } else {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|integer',
        ]);
        $price = str_replace('.', '', $request->post('price'));

        $product = Product::find($id);

        if ($product) {
            $dataToUpdate = [
                'name' => $validatedData['name'],
                'price' => $price,
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                // Store new image and resize
                $imagePath = $request->file('image')->store('product_image', 'public');
                $image = Image::make(Storage::disk('public')->path($imagePath));
                $image->resize(1080, 1351)->save(); // Adjust size as needed

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
