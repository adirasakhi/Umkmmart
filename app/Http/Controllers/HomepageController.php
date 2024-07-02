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
        $popularProduct = Product::select(
            'product.id',
            'product.name',
            'users.name as saller_name',
            DB::raw('COUNT(product_clicks.id) as click_count')
        )
        ->join('product_clicks', 'product.id', '=', 'product_clicks.product_id')
        ->join('users', 'product.seller_id', '=', 'users.id')

        ->whereDate('product_clicks.clicked_at', '>=', Carbon::now()->subDays(30))
        ->groupBy(
            'product.id',
            'product.name',
            'users.name'
        )
        ->orderByDesc('click_count')
        ->take(10)
        ->get();


        return view('pages.Landing.index', ['popularProduct' => $popularProduct, 'slide'=> $bannerSlide, 'bannerHead'=> $bannerHead, 'about'=>$about]);
    }

}
