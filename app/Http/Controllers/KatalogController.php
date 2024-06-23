<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    public function index(Request $request){
        $categoryId = $request->input('id');
        $categories = Category::withCount('products')->get();
        if ($categoryId) {
            $products = Product::where('category_id', $categoryId)->get();
        } else {
            $products = Product::all();
        }

        return view('pages.Landing.shop', compact('products', 'categories', 'categoryId'));
    }

    public function katalog() {
        $products = Product::all();
        $categories = Category::withCount('products')->get();
        return view('pages.Landing.shop', ['products' => $products, 'categories' => $categories]);
    }

    public function detail($id) {
        $product = Product::find($id);
        $categories = Category::all();
        $user = User::all();
        $social_media = SocialMedia::all();
        $related_products = Product::where('category_id', $product->category_id) // Filter berdasarkan kategori yang sama
    ->where('id', '!=', $product->id) // Kecualikan produk yang sedang ditampilkan
    ->limit(3)
    ->get();


        if (!$product) {
            // handle the case when product is not found
            return redirect()->route('katalog.index')->with('error', 'Product not found.');
        }

        return view('pages.Landing.Detail', ['product' => $product, 'categories' => $categories, 'user'=>$user, 'social_media' => $social_media ,'related_products' => $related_products]);
    }

    /*public function sort($categoryId)
    {
        $category = Category::with('products')->find($categoryId);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        return view('pages.dashboard.bykategori', compact('category'));
    }*/
    public function filter(Request $request)
    {
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');
        $query = Product::query();

    if (!is_null($minPrice)) {
        $query->where('price', '>=', $minPrice);
    }

    if (!is_null($maxPrice)) {
        $query->where('price', '<=', $maxPrice);
    }

    $products = $query->get();
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories'));
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
