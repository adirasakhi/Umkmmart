<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $categoryCount = Category::count();
        $productCount = Product::count();

        // Ambil data produk per hari dalam seminggu terakhir
        $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Konversi data ke format yang sesuai untuk chart
        $labels = [];
        $data = [];
        foreach ($productRegistrations as $registration) {
            $labels[] = Carbon::parse($registration->date)->format('l'); // Mengambil nama hari
            $data[] = $registration->count;
        }

        // Data detail statistik
        $dailyProducts = Product::whereDate('created_at', Carbon::today())->count();
        $weeklyProducts = Product::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyProducts = Product::whereMonth('created_at', Carbon::now()->month)->count();

        // Menentukan perubahan harian, mingguan, dan bulanan
        $previousDailyProducts = Product::whereDate('created_at', Carbon::yesterday())->count();
        $previousWeeklyProducts = Product::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        $previousMonthlyProducts = Product::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        $details = [
            [
                'change' => $dailyProducts >= $previousDailyProducts ? 'up' : 'down',
                'plus' => $dailyProducts >= $previousDailyProducts ? $dailyProducts - $previousDailyProducts : '-',
                'value' => $dailyProducts,
                'label' => "Produk Per Hari"
            ],
            [
                'change' => $weeklyProducts >= $previousWeeklyProducts ? 'up' : 'down',
                'plus' => $weeklyProducts >= $previousWeeklyProducts ? $weeklyProducts - $previousWeeklyProducts : '-',
                'value' => $weeklyProducts,
                'label' => "Produk Per Minggu"
            ],
            [
                'change' => $monthlyProducts >= $previousMonthlyProducts ? 'up' : 'down',
                'plus' => $monthlyProducts >= $previousMonthlyProducts ? $monthlyProducts - $previousMonthlyProducts : '-',
                'value' => $monthlyProducts,
                'label' => "Produk Per Bulan"
            ],
        ];

        return view('pages.dashboard.content-dashboard', compact('usersCount', 'categoryCount', 'productCount', 'labels', 'data', 'details'));
    }
}
