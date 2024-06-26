<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $usersCount = User::count();
            $categoryCount = Category::count();

            // Admin role_id = 1, User role_id = 2
            if ($user->role_id === 1) {
                $productCount = Product::count();

                // Ambil data produk per hari dalam seminggu terakhir
                $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                    ->where('created_at', '>=', Carbon::now()->subWeek())
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();
            } else {
                $productCount = Product::where('seller_id', $user->id)->count();

                // Ambil data produk per hari dalam seminggu terakhir
                $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                    ->where('seller_id', $user->id)
                    ->where('created_at', '>=', Carbon::now()->subWeek())
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();
            }

            // Konversi data ke format yang sesuai untuk chart
            $labels = [];
            $data = [];
            foreach ($productRegistrations as $registration) {
                $labels[] = Carbon::parse($registration->date)->format('l'); // Mengambil nama hari
                $data[] = $registration->count;
            }

            // Data detail statistik
            if ($user->role_id === 1) {
                $dailyProducts = Product::whereDate('created_at', Carbon::today())->count();
                $weeklyProducts = Product::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $monthlyProducts = Product::whereMonth('created_at', Carbon::now()->month)->count();
                $yearlyProducts = Product::whereYear('created_at', Carbon::now()->year)->count();

                $previousDailyProducts = Product::whereDate('created_at', Carbon::yesterday())->count();
                $previousWeeklyProducts = Product::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
                $previousMonthlyProducts = Product::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
                $previousYearlyProducts = Product::whereYear('created_at', Carbon::now()->subYear()->year)->count();


                $dailyUsers = User::whereDate('created_at', Carbon::today())->count();
                $weeklyUsers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $monthlyUsers = User::whereMonth('created_at', Carbon::now()->month)->count();
                $yearlyUsers = User::whereYear('created_at', Carbon::now()->year)->count();

                $previousDailyUsers = User::whereDate('created_at', Carbon::yesterday())->count();
                $previousWeeklyUsers = User::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
                $previousMonthlyUsers = User::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
                $previousYearlyUsers = User::whereYear('created_at', Carbon::now()->subYear()->year)->count();
            } else {
                $dailyProducts = Product::where('seller_id', $user->id)->whereDate('created_at', Carbon::today())->count();
                $weeklyProducts = Product::where('seller_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $monthlyProducts = Product::where('seller_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->count();
                $yearlyProducts = Product::where('seller_id', $user->id)->whereYear('created_at', Carbon::now()->year)->count();

                $previousDailyProducts = Product::where('seller_id', $user->id)->whereDate('created_at', Carbon::yesterday())->count();
                $previousWeeklyProducts = Product::where('seller_id', $user->id)->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
                $previousMonthlyProducts = Product::where('seller_id', $user->id)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
                $previousYearlyProducts = Product::where('seller_id', $user->id)->whereYear('created_at', Carbon::now()->subYear()->year)->count();

                $dailyUsers = User::whereDate('created_at', Carbon::today())->count();
                $weeklyUsers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $monthlyUsers = User::whereMonth('created_at', Carbon::now()->month)->count();
                $yearlyUsers = User::whereYear('created_at', Carbon::now()->year)->count();

                $previousDailyUsers = User::whereDate('created_at', Carbon::yesterday())->count();
                $previousWeeklyUsers = User::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
                $previousMonthlyUsers = User::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
                $previousYearlyUsers = User::whereYear('created_at', Carbon::now()->subYear()->year)->count();
            }

            $detailProducts = [
                [
                    'change' => $dailyProducts >= $previousDailyProducts ? 'up' : 'down',
                    'plus' => $dailyProducts >= $previousDailyProducts ? $dailyProducts - $previousDailyProducts : '-',
                    'value' => $dailyProducts,
                    'label' => "Produk Per Hari Ini"
                ],
                [
                    'change' => $weeklyProducts >= $previousWeeklyProducts ? 'up' : 'down',
                    'plus' => $weeklyProducts >= $previousWeeklyProducts ? $weeklyProducts - $previousWeeklyProducts : '-',
                    'value' => $weeklyProducts,
                    'label' => "Produk Per Minggu Ini"
                ],
                [
                    'change' => $monthlyProducts >= $previousMonthlyProducts ? 'up' : 'down',
                    'plus' => $monthlyProducts >= $previousMonthlyProducts ? $monthlyProducts - $previousMonthlyProducts : '-',
                    'value' => $monthlyProducts,
                    'label' => "Produk Per Bulan Ini"
                ],
                [
                    'change' => $yearlyProducts >= $previousYearlyProducts ? 'up' : 'down',
                    'plus' => $yearlyProducts >= $previousYearlyProducts ? $yearlyProducts - $previousYearlyProducts : '-',
                    'value' => $yearlyProducts,
                    'label' => "Produk Per Tahun Ini"
                ],
            ];

            $detailUsers = [
                [
                    'change' => $dailyUsers >= $previousDailyUsers ? 'up' : 'down',
                    'plus' => $dailyUsers >= $previousDailyUsers ? $dailyUsers - $previousDailyUsers : '-',
                    'value' => $dailyUsers,
                    'label' => "User Per Hari Ini"
                ],
                [
                    'change' => $weeklyUsers >= $previousWeeklyUsers ? 'up' : 'down',
                    'plus' => $weeklyUsers >= $previousWeeklyUsers ? $weeklyUsers - $previousWeeklyUsers : '-',
                    'value' => $weeklyUsers,
                    'label' => "User Per Minggu Ini"
                ],
                [
                    'change' => $monthlyUsers >= $previousMonthlyUsers ? 'up' : 'down',
                    'plus' => $monthlyUsers >= $previousMonthlyUsers ? $monthlyUsers - $previousMonthlyUsers : '-',
                    'value' => $monthlyUsers,
                    'label' => "User Per Bulan Ini"
                ],
                [
                    'change' => $yearlyUsers >= $previousYearlyUsers ? 'up' : 'down',
                    'plus' => $yearlyUsers >= $previousYearlyUsers ? $yearlyUsers - $previousYearlyUsers : '-',
                    'value' => $yearlyUsers,
                    'label' => "User Per Tahun Ini"
                ],
            ];

            return view('pages.dashboard.content-dashboard', compact('usersCount', 'categoryCount', 'productCount', 'labels', 'data', 'detailProducts', 'detailUsers'));
        } else {
            // Handle case where user is not authenticated
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses dashboard.');
        }
    }

    public function getWeeklyData()
    {
        $user = Auth::user();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        if ($user->role_id === 1) {
            $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } else {
            $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->where('seller_id', $user->id)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        }

        $labels = [];
        $data = [];

        // Ensure the labels are for the last 7 days
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            $labels[] = $date->format('l');
            $data[] = 0; // Initialize with zero
        }

        foreach ($productRegistrations as $registration) {
            $index = Carbon::parse($registration->date)->dayOfWeek;
            $data[$index] = $registration->count;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function getMonthlyData()
    {
        $user = Auth::user();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        if ($user->role_id === 1) {
            $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } else {
            $productRegistrations = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->where('seller_id', $user->id)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        }

        $labels = [];
        $data = [];

        // Ensure the labels are for all days of the month
        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $labels[] = $date->format('j');
            $data[] = 0; // Initialize with zero
        }

        foreach ($productRegistrations as $registration) {
            $index = Carbon::parse($registration->date)->day - 1;
            $data[$index] = $registration->count;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
    public function getYearlyData()
    {
        $user = Auth::user();
        $labels = [];
        $data = [];

        if ($user->role_id === 1) {
            $productRegistrations = Product::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        } else {
            $productRegistrations = Product::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->where('seller_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        }

        foreach ($productRegistrations as $registration) {
            $labels[] = Carbon::create(null, $registration->month, 1)->format('F'); // Format to month name
            $data[] = $registration->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function getUserWeeklyData()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $usersRegistrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = [];
        $data = [];

        // Ensure the labels are for the last 7 days
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            $labels[] = $date->format('l');
            $data[] = 0; // Initialize with zero
        }

        foreach ($usersRegistrations as $registration) {
            $index = Carbon::parse($registration->date)->dayOfWeek;
            $data[$index] = $registration->count;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
    public function getUserMonthlyData()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $usersRegistrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();


        $labels = [];
        $data = [];

        // Ensure the labels are for all days of the month
        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $labels[] = $date->format('j');
            $data[] = 0; // Initialize with zero
        }

        foreach ($usersRegistrations as $registration) {
            $index = Carbon::parse($registration->date)->day - 1;
            $data[$index] = $registration->count;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
    public function getUserYearlyData()
    {
        $labels = [];
        $data = [];

        $usersRegistrations = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();


        foreach ($usersRegistrations as $registration) {
            $labels[] = Carbon::create(null, $registration->month, 1)->format('F'); // Format to month name
            $data[] = $registration->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
