<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductClick;
use App\Models\Category;
use App\Models\SocialMedia;
use App\Models\Variant;
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

        $subquery = DB::table('variants')
            ->select('product_id', DB::raw('MIN(price) as min_price'))
            ->groupBy('product_id');

        $query = DB::table('product')
            ->joinSub($subquery, 'min_variants', function ($join) {
                $join->on('product.id', '=', 'min_variants.product_id');
            })
            ->join('variants', function ($join) {
                $join->on('product.id', '=', 'variants.product_id')
                    ->whereColumn('variants.price', '=', 'min_variants.min_price');
            })
            ->join('users', 'product.seller_id', '=', 'users.id')
            ->select('product.*', 'variants.image as min_variant_image', 'users.name as seller_name', 'min_variants.min_price as min_price');

        // Memuat relasi Seller untuk setiap produk
        $products = $query->paginate(12);

        return view('pages.Landing.shop', compact('products', 'categories', 'categoryId', 'minPrice', 'maxPrice'));
    }


    public function detail($id)
    {
        // Temukan produk berdasarkan ID
        $product = Product::with('variants', 'seller')->find($id);

        // Redirect jika produk tidak ditemukan
        if (!$product) {
            return redirect()->route('katalog.index')->with('error', 'Product not found.');
        }

        // Ambil semua kategori
        $categories = Category::all();

        // Ambil semua pengguna (mungkin Anda ingin filter ini lebih spesifik)
        $users = User::all();

        // Ambil semua media sosial
        $social_media = SocialMedia::all();

        // Ambil produk terkait berdasarkan kategori yang sama, kecuali produk saat ini
        $subquery = DB::table('variants')
            ->select('product_id', DB::raw('MIN(price) as min_price'))
            ->groupBy('product_id');

        $related_products = DB::table('product')
            ->joinSub($subquery, 'min_variants', function ($join) {
                $join->on('product.id', '=', 'min_variants.product_id');
            })
            ->join('variants', function ($join) {
                $join->on('product.id', '=', 'variants.product_id')
                    ->whereColumn('variants.price', '=', 'min_variants.min_price');
            })
            ->join('users', 'product.seller_id', '=', 'users.id')
            ->where('product.category_id', $product->category_id)
            ->where('product.id', '!=', $product->id)
            ->select('product.*', 'variants.image as min_variant_image', 'users.name as seller_name', 'min_variants.min_price as min_price')
            ->limit(4)
            ->get();

        // Mengidentifikasi perangkat menggunakan IP address atau metode lain
        $deviceId = request()->ip();

        // Cek jika sudah ada klik untuk produk ini hari ini dari perangkat ini
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

        // Menghitung harga setelah diskon
        foreach ($product->variants as $variant) {
            $variant->discounted_price = $variant->getDiscountedPriceAttribute();
        }

        // Kembalikan view dengan data yang diperlukan
        return view('pages.Landing.Detail', [
            'product' => $product,
            'categories' => $categories,
            'users' => $users,
            'social_media' => $social_media,
            'related_products' => $related_products,
            'variants' => $product->variants,
        ]);
    }


    public function filter(Request $request)
    {
        $categoryId = $request->input('id');
        $keywords = $request->input('keywords');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');
        $sort = $request->input('sort', 'asc');

        // Subquery to get the minimum price and corresponding variant id for each product
        $subquery = DB::table('variants')
            ->select('product_id', DB::raw('MIN(price) as min_price'))
            ->groupBy('product_id');

        $query = DB::table('product')
            ->joinSub($subquery, 'min_variants', function ($join) {
                $join->on('product.id', '=', 'min_variants.product_id');
            })
            ->join('variants', function ($join) {
                $join->on('product.id', '=', 'variants.product_id')
                    ->whereColumn('variants.price', '=', 'min_variants.min_price');
            })
            ->join('users', 'product.seller_id', '=', 'users.id')
            ->select('product.*', 'variants.image as min_variant_image', 'users.name as seller_name', 'min_variants.min_price as min_price');

        if (isset($categoryId) && ($categoryId != null)) {
            $query->where('product.category_id', $categoryId);
        }

        if (isset($minPrice) && ($minPrice != null)) {
            $query->where('min_variants.min_price', '>=', $minPrice);
        }

        if (isset($maxPrice) && ($maxPrice != null)) {
            $query->where('min_variants.min_price', '<=', $maxPrice);
        }

        if (isset($keywords) && ($keywords != null)) {
            $keywordArray = explode(' ', $keywords);
            foreach ($keywordArray as $keyword) {
                $query->where('product.name', 'like', '%' . $keyword . '%');
            }
        }

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'asc';
        }

        $query->orderBy('min_variants.min_price', $sort);

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories', 'minPrice', 'maxPrice', 'sort'));
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        $categoryId = $request->input('id');
        $minPrice = $request->input('min');
        $maxPrice = $request->input('max');
        $sort = $request->input('sort', 'asc');

        // Subquery untuk mendapatkan harga minimum dan id varian yang sesuai untuk setiap produk
        $subquery = DB::table('variants')
            ->select('product_id', DB::raw('MIN(price) as min_price'))
            ->groupBy('product_id');

        $query = DB::table('product')
            ->joinSub($subquery, 'min_variants', function ($join) {
                $join->on('product.id', '=', 'min_variants.product_id');
            })
            ->join('variants', function ($join) {
                $join->on('product.id', '=', 'variants.product_id')
                    ->whereColumn('variants.price', '=', 'min_variants.min_price');
            })
            ->join('users', 'product.seller_id', '=', 'users.id')
            ->select('product.*', 'variants.image as min_variant_image', 'users.name as seller_name', 'min_variants.min_price as min_price');

        if (!is_null($categoryId)) {
            $query->where('product.category_id', $categoryId);
        }

        if (!is_null($minPrice)) {
            $query->where('min_variants.min_price', '>=', $minPrice);
        }

        if (!is_null($maxPrice)) {
            $query->where('min_variants.min_price', '<=', $maxPrice);
        }

        if (!empty($keywords)) {
            $keywordArray = explode(' ', $keywords);
            foreach ($keywordArray as $keyword) {
                $query->where('product.name', 'like', '%' . $keyword . '%');
            }
        }

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'asc';
        }

        $query->orderBy('min_variants.min_price', $sort);

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('pages.Landing.shop', compact('products', 'categories', 'minPrice', 'maxPrice', 'sort'));
    }


    // public function getPopularProduct()
    // {
    //     $user = User::all();
    //     $popularProduct = Product::select(
    //         'product.id',
    //         'product.name',
    //         // 'product.price',
    //         // 'product.image',
    //         'users.name as seller_name',
    //         DB::raw('COUNT(product_clicks.id) as click_count')
    //     )
    //         ->join('product_clicks', 'product.id', '=', 'product_clicks.product_id')
    //         ->join('users', 'product.seller_id', '=', 'users.id')

    //         ->whereDate('product_clicks.clicked_at', '>=', Carbon::now()->subDays(30))
    //         ->groupBy(
    //             'product.id',
    //             'product.name',
    //             // 'product.price',
    //             // 'product.image',
    //             'users.name'
    //         )
    //         ->orderByDesc('click_count')
    //         ->take(10)
    //         ->get();

    //     return view('pages.Landing.index', ['popularProduct' => $popularProduct]);
    // }
}
