<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('id');

        if ($categoryId) {
            $products = Product::where('category_id', $categoryId)->get();
        } else {
            $products = Product::all();
        }

        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories'));
    }
    public function katalog() {
        $products = Product::all();
        $categories = Category::withCount('products')->get();
        return view('pages.Landing.shop', ['products' => $products, 'categories' => $categories]);
    }

    public function detail($id) {
        $product = Product::find($id);
        $categories = Category::all();

        if (!$product) {
            // handle the case when product is not found
            return redirect()->route('katalog.index')->with('error', 'Product not found.');
        }

        return view('pages.Landing.Detail', ['product' => $product, 'categories' => $categories]);
    }
    /*public function sort($categoryId)
    {
        $category = Category::with('products')->find($categoryId);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        return view('pages.dashboard.bykategori', compact('category'));
    }*/
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")
                           ->orWhere('description', 'LIKE', "%{$query}%")
                           ->get();

        return view('products.search', compact('products'));
    }

}
