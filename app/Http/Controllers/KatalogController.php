<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductClick;
use App\Models\SocialMedia;
use App\Models\User;
use Carbon\Carbon;
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
        $deviceId = request()->ip(); // Atau gunakan metode lain untuk mengidentifikasi perangkat

        // Cari klik yang sudah ada dari perangkat yang sama pada hari yang sama
        $existingClick = ProductClick::where('product_id', $id)
        ->where('device_id', $deviceId)
        ->whereDate('clicked_at', Carbon::today())
        ->first();

        if ($existingClick) {
        // Jika sudah ada, tambahkan jumlah klik
            $existingClick->increment('click_count');
        } else {
        // Jika belum ada, buat entri baru dengan click_count = 1
            ProductClick::create([
                'product_id' => $id,
                'device_id' => $deviceId,
                'clicked_at' => Carbon::now(),
                'click_count' => 1,
            ]);
        }

        return view('pages.Landing.Detail', ['product' => $product, 'categories' => $categories, 'user' => $user, 'social_media' => $social_media, 'related_products' => $related_products]);
    }

    public function filter(Request $request)
    {
        // dd($request->all());
        $categoryId = $request->input('id');
        $keywords = $request->input('keywords');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');
        $sort = $request->input('sort','asc','desc');
        $query = Product::query();

        if (isset ($categoryId) && (($categoryId != null))) {
            $query->where('category_id', $categoryId);
        }

        if (isset ($minPrice) && ($minPrice != null)) {
            $query->where('price', '>=', $minPrice);
        }

        if (isset ($maxPrice) && ($maxPrice != null)) {
            $query->where('price', '<=', $maxPrice);
        }

        if(isset ($keywords) && ($keywords != null) ){
            $keywordArray = explode(' ', $keywords);
            foreach ($keywordArray as $keyword) {
                $query = $query->Where('name', 'like', '%'.$keyword.'%');
            }
        }

        if(!in_array($sort, ['asc','desc'])){
            $sort = 'asc';
        }
        $query->orderBy('price', $sort);

        $products = $query->paginate(10);
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories', 'minPrice', 'maxPrice','sort'));
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        $categoryId = $request->input('id');
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

        return view('pages.Landing.shop', compact('products', 'categories'));
    }
    public function getPopularProduct()
    {
        $user = User::all();
        $popularProduct = Product::select(
            'product.id',
            'product.name',
            'product.price',
            'product.image',
            'users.name as saller_name',
            DB::raw('COUNT(product_clicks.id) as click_count')
        )
        ->join('product_clicks', 'product.id', '=', 'product_clicks.product_id')
         ->join('users', 'product.seller_id', '=', 'users.id')
        ->whereDate('product_clicks.clicked_at', '>=', Carbon::now()->subDays(30))
        ->groupBy(
            'product.id',
            'product.name',
            'product.price',
            'product.image',
            'users.name'
        )
        ->orderByDesc('click_count')
        ->take(10)
        ->get();

        return view('pages.Landing.index', ['popularProduct' => $popularProduct]);

    }
}