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
    public function index(Request $request)
    {
        $categoryId = $request->input('id');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');
        $keywords = $request->input('keywords');

        $categories = Category::withCount('products')->get();

        $query = Product::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if (!is_null($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (!is_null($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        if (!empty($keywords)) {
            $keywordArray = explode(' ', $keywords);
            foreach ($keywordArray as $keyword) {
                $query->where('name', 'like', '%' . strtolower($keyword) . '%');
            }
        }

        $products = $query->paginate(10);

        return view('pages.Landing.shop', compact('products', 'categories', 'categoryId', 'minPrice', 'maxPrice'));
    }

    public function katalog()
    {
        $products = Product::paginate(10);
        $categories = Category::withCount('products')->get();
        return view('pages.Landing.shop', ['products' => $products, 'categories' => $categories]);
    }

    public function detail($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $user = User::all();
        $social_media = SocialMedia::all();
        $related_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        if (!$product) {
            return redirect()->route('katalog.index')->with('error', 'Product not found.');
        }

        return view('pages.Landing.Detail', ['product' => $product, 'categories' => $categories, 'user' => $user, 'social_media' => $social_media, 'related_products' => $related_products]);
    }

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

        $products = $query->paginate(10);
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories', 'minPrice', 'maxPrice'));
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        $categoryId = $request->input('category');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');

        $query = Product::query()
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when(!is_null($minPrice), function ($query) use ($minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when(!is_null($maxPrice), function ($query) use ($maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            });

        if (!empty($keywords)) {
            $keywordArray = explode(' ', $keywords);
            foreach ($keywordArray as $keyword) {
                $query->where('name', 'like', '%' . strtolower($keyword) . '%');
            }
        }

        $products = $query->paginate(10);
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.result', compact('products', 'categories'));
    }
}
