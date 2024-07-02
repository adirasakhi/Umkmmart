<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Banner;
use App\Models\About;
use App\Models\User;
use Carbon\Carbon;


class HomepageController extends Controller
{
    public function index()
    {
        $bannerSlide = Banner::where('type', 'slideshow')->get();
        $bannerHead = Banner::where('type', 'head')->first();
        $user = User::all();
        $about = About::all()->first();
        $subquery = DB::table('variants')
            ->select('product_id', DB::raw('MIN(price) as min_price'))
            ->groupBy('product_id');

        $popularProduct = DB::table('product')
            ->joinSub($subquery, 'min_variants', function ($join) {
                $join->on('product.id', '=', 'min_variants.product_id');
            })
            ->join('variants', function ($join) {
                $join->on('product.id', '=', 'variants.product_id')
                    ->whereColumn('variants.price', '=', 'min_variants.min_price');
            })
            ->join('users', 'product.seller_id', '=', 'users.id')
            ->select('product.id', 'product.name', 'min_variants.min_price as min_price', 'variants.image as min_variant_image', 'users.name as seller_name')
            ->limit(6)
            ->get();


        return view('pages.Landing.index', ['popularProduct' => $popularProduct, 'slide' => $bannerSlide, 'bannerHead' => $bannerHead, 'about' => $about]);
    }
}
