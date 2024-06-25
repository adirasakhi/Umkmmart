<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductClick;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role_id == 2) {
            $productCount = Product::where('seller_id', $user->id)->count();
            $totalClicks = ProductClick::whereIn('product_id', Product::where('seller_id', $user->id)->pluck('id'))->count();

            // Get the count of clicks per product for the seller
            $clicksPerProduct = Product::where('seller_id', $user->id)
                ->withCount('clicks')
                ->get()
                ->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'clicks_count' => $product->clicks_count,
                    ];
                });

            $stats = [
                'productCount' => $productCount,
                'totalClicks' => $totalClicks,
                'clicksPerProduct' => $clicksPerProduct,
            ];

            return view('pages.dashboard.content-dashboard-seller', $stats);
        } else {
            $usersCount = User::count();
            $categoryCount = Category::count();
            $productCount = Product::count();
            $totalVisitors = Visitor::count();

            // Get the count of products per category
            $productsPerCategory = Category::withCount('products')->get();

            // Prepare data for total visitors chart
            $totalVisitorsData = $this->prepareTotalVisitorsData();

            $stats = [
                'usersCount' => $usersCount,
                'categoryCount' => $categoryCount,
                'productCount' => $productCount,
                'totalVisitors' => $totalVisitors,
                'productsPerCategory' => $productsPerCategory,
                'totalVisitorsData' => $totalVisitorsData,
            ];

            return view('pages.dashboard.content-dashboard', $stats);
        }
    }

    private function prepareTotalVisitorsData()
    {
        // Get daily visitors for the last 30 days
        $dailyVisitors = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date');

        // Get monthly visitors for the last 12 months
        $monthlyVisitors = Visitor::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->pluck('count', 'month');

        return [
            'labels' => $dailyVisitors->keys(),
            'daily' => $dailyVisitors->values(),
            'monthly' => $monthlyVisitors->values(),
        ];
    }
}

