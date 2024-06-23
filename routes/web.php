<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialmediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('pages.Landing.index');
});
// Auth routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::post('/action-register', [AuthController::class, 'registerAction'])->name('registerAction'); // disini ada coding untuk save user
Route::post('/action-login', [AuthController::class, 'loginAction'])->name('loginAction'); // disini ada coding untuk check user
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// katalog Routes
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/detail/{id}', [KatalogController::class, 'detail'])->name('katalog.detail');
Route::get('/katalog/search', [KatalogController::class, "search"])->name('katalog.search');
Route::get('/katalog/filter', [KatalogController::class, 'filter'])->name('katalog.filter');
Route::get('/katalog/search', [KatalogController::class, 'search'])->name('katalog.search');


Route::middleware('auth', 'role')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/weekly', [DashboardController::class, 'getWeeklyData'])->name('dashboard.weekly');
    Route::get('/dashboard/monthly', [DashboardController::class, 'getMonthlyData'])->name('dashboard.monthly');
    Route::get('/dashboard/yearly', [DashboardController::class, 'getYearlyData'])->name('dashboard.yearly');
    Route::get('/dashboard/user/weekly', [DashboardController::class, 'getUserWeeklyData'])->name('dashboard.user.weekly');
    Route::get('/dashboard/user/monthly', [DashboardController::class, 'getUserMonthlyData'])->name('dashboard.user.monthly');
    Route::get('/dashboard/user/yearly', [DashboardController::class, 'getUserYearlyData'])->name('dashboard.user.yearly');

    // Kategori Routes
    Route::get('/kategori', [CategoryController::class, "index"])->name('kategori');
    Route::post('/kategori/insert', [CategoryController::class, "store"])->name('kategori.add');
    Route::post('/kategori/edit', [CategoryController::class, "edit"])->name('kategori.edit');
    Route::post('/kategori/update/{id}', [CategoryController::class, "update"])->name('kategori.update');
    Route::delete('/kategori/delete/{id}', [CategoryController::class, "destroy"])->name('category.delete');

    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/users/profile/update/{id}', [UserController::class, 'updateProfile'])->name('users.profile.update');
    Route::get('/users/registered', [UserController::class, 'registered'])->name('users.registered');
    Route::post('/users/showActive', [UserController::class, 'showActive'])->name('showActive');
    Route::post('/users/showInactive', [UserController::class, 'showInactive'])->name('showInactive');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Sosmed Routes
    Route::get('/sosial-media', [SocialmediaController::class, "index"])->name('sosial-media');
    Route::post('/sosial-media/insert', [SocialmediaController::class, "store"])->name('sosial-media.insert');
    Route::post('/sosial-media/edit', [SocialmediaController::class, "edit"])->name('sosial-media.edit');
    Route::post('/sosial-media/update/{id}', [SocialmediaController::class, "update"])->name('sosial-media.update');
    Route::delete('/sosial-media/delete/{id}', [SocialmediaController::class, "destroy"])->name('sosial-media.delete');
});
