<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
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
            $products = Product::with('variants')->get();
        } else {
            $user = Auth::user();
            $products = Product::where('seller_id', $user->id)->with('variants')->get();
        }
        $categories = Category::all();
        return view('pages.product.product', ['products' => $products, 'categories' => $categories, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'seller_id' => 'required_if:role_id,1|integer',
        ]);

        $sellerId = ($user->role_id == 2) ? $user->id : $validatedData['seller_id'];

        // Create the product
        $product = Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'seller_id' => $sellerId,
        ]);

        // Simpan product_id di session
    session()->flash('product_id', $product->id);

    // Redirect ke halaman produk
    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function storeVariant(Request $request, Product $product)
    {
        $customMessages = [
            'variant_name.required' => 'Nama varian wajib diisi.',
            'variant_name.*.required' => 'Nama varian wajib diisi.',
            'variant_name.*.max' => 'Panjang maksimum nama varian adalah 255 karakter.',
            'variant_price.required' => 'Harga varian wajib diisi.',
            'variant_price.*.required' => 'Harga varian wajib diisi.',
            'variant_price.*.integer' => 'Harga varian harus berupa angka.',
            'variant_image.required' => 'Gambar varian wajib diunggah.',
            'variant_image.*.required' => 'Gambar varian wajib diunggah.',
            'variant_image.*.image' => 'File harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'variant_image.*.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
            'variant_image.*.max' => 'Ukuran gambar maksimum adalah 2MB.',
            'variant_discount.integer' => 'Diskon varian harus berupa angka.',
        ];

        $request->validate([
            'variant_name' => 'required|array',
            'variant_name.*' => 'required|string|max:255',
            'variant_price' => 'required|array',
            'variant_price.*' => 'required|integer',
            'variant_image' => 'required|array',
            'variant_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variant_discount' => 'nullable|array',
            'variant_discount.*' => 'nullable|integer',
        ], $customMessages);

        try {
            foreach ($request->variant_name as $key => $variantName) {
                $variant = new Variant();
                $variant->product_id = $product->id;
                $variant->name = $variantName;
                $variant->price = str_replace('.', '', $request->variant_price[$key]);
                $variant->discount = $request->variant_discount[$key] ?? null;

                $imagePath = $request->file('variant_image')[$key]->store('variant_images', 'public');
                $image = Image::make(Storage::disk('public')->path($imagePath));
                $image->resize(1080, 1351)->save();
                $variant->image = $imagePath;

                $variant->save();
            }

            return redirect()->route('products.index')->with('success', 'Varian berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan varian: ' . $e->getMessage());
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
            'description' => 'required|string',
            'category_id' => 'required|integer',
        ]);
        $price = str_replace('.', '', $request->post('price'));

        $product = Product::find($id);
        if ($product) {
            $dataToUpdate = [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
            ];

            $product->update($dataToUpdate);

            return redirect()->route('products.index')->with('success', 'Product berhasil diupdate');
        } else {
            return redirect()->route('products.index')->with('error', 'Product tidak ditemukan');
        }
    }

    public function updateVariant(Request $request, $id)
    {
        $customMessages = [
            'variant_name.required' => 'Nama varian wajib diisi.',
            'variant_name.string' => 'Nama varian harus berupa teks.',
            'variant_name.max' => 'Panjang maksimum nama varian adalah 255 karakter.',
            'variant_price.required' => 'Harga varian wajib diisi.',
            'variant_price.integer' => 'Harga varian harus berupa angka.',
            'variant_image.image' => 'File harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'variant_image.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
            'variant_image.max' => 'Ukuran gambar maksimum adalah 2MB.',
            'variant_discount.integer' => 'Diskon varian harus berupa angka.',
        ];

        $validatedData = $request->validate([
            'variant_name' => 'required|string|max:255',
            'variant_price' => 'required|integer',
            'variant_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variant_discount' => 'nullable|integer',
        ], $customMessages);

        $variant = Variant::find($id);
        if ($variant) {
            $dataToUpdate = [
                'name' => $validatedData['variant_name'],
                'price' => $validatedData['variant_price'],
                'discount' => $validatedData['variant_discount'],
            ];

            // Periksa apakah ada file gambar yang diunggah
            if ($request->hasFile('variant_image')) {
                // Hapus gambar lama jika ada
                if ($variant->image) {
                    Storage::delete('public/' . $variant->image);
                }
                // Simpan gambar baru
                $imagePath = $request->file('variant_image')->store('variant_images', 'public');
                $image = Image::make(Storage::disk('public')->path($imagePath));
                $image->resize(1080, 1351)->save();
                $dataToUpdate['image'] = $imagePath;
            }

            $variant->update($dataToUpdate);

            return redirect()->route('products.index')->with('success', 'Varian berhasil diupdate');
        }

        return redirect()->route('products.index')->with('error', 'Varian tidak ditemukan');
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

    public function deleteVariant($id)
    {
        $variant = Variant::find($id);
        if ($variant) {
            // Hapus gambar jika ada
            if ($variant->image) {
                Storage::delete('public/' . $variant->image);
            }
            // Hapus varian
            $variant->delete();

            return redirect()->route('products.index')->with('success', 'Varian berhasil dihapus');
        }

        return redirect()->route('products.index')->with('error', 'Varian tidak ditemukan');
    }
}
