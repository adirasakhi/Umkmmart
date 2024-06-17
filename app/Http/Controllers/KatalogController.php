<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function katalog() {
        $products = Product::all();
        $categories = Category::all();
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

}
