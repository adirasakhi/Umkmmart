<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('pages.Landing.shop', compact('products', 'categories', "categoryId"));
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
    public function filter(Request $request)
    {

        $categoryId = $request->input('category');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');
        $products = Product::where('category_id', $categoryId)
        ->whereBetween('price', [$minPrice, $maxPrice])
        ->get();
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories', "categoryId"));
    }
    public function search(Request $request)
    {
    // Ambil input dari request
        $keywords = $request->input('keywords');
        $categoryId = $request->input('category');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');

        $products = Product::query();

        if ($categoryId) {
            $products->where('category_id', $categoryId)
            ->whereBetween('price', [$minPrice, $maxPrice]);
        }

        if (strtolower($keywords) && $minPrice && $maxPrice) {
            $products->where('name', 'like', '%' . strtolower($keywords) . '%')
            ->whereBetween('price', [$minPrice, $maxPrice]);
        }
        if(strtolower($keywords) ){
            $keywordArray = explode(' ', $keywords);
            foreach ($keywordArray as $keyword) {
                $products = $products->Where('name', 'like', '%'.$keyword.'%');
            }
        }

        $products = $products->get();

        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'keywords', 'categoryId', 'categories'));
    }



}
