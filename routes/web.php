<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialmediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;





/*Route::get('/', function () {
    return view('pages.Landing.index');
});*/

Route::get('/', [KatalogController::class, 'getPopularProduct']);

Route::middleware(['visitor'])->group(function () {
    Route::get('/', [KatalogController::class, 'getPopularProduct']);
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::post('/action-register', [AuthController::class, 'registerAction'])->name('registerAction');
Route::post('/action-login', [AuthController::class, 'loginAction'])->name('loginAction');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/detail/{id}', [KatalogController::class, 'detail'])->name('katalog.detail');
Route::get('/katalog/filter', [KatalogController::class, 'filter'])->name('katalog.filter');
Route::get('/katalog/search', [KatalogController::class, 'search'])->name('katalog.search');
Route::middleware('auth', 'role')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Kategori Routes
    Route::get('/kategori', [CategoryController::class, "index"])->name('kategori');
    Route::post('/kategori/insert', [CategoryController::class, "store"])->name('kategori.add');
    Route::post('/kategori/edit', [CategoryController::class, "edit"])->name('kategori.edit');
    Route::post('/kategori/update/{id}', [CategoryController::class, "update"])->name('kategori.update');
    Route::delete('/kategori/delete/{id}', [CategoryController::class, "destroy"])->name('category.delete');

    // User routes

    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/profile/update/{id}', [UserController::class, 'updateProfile'])->name('users.profile.update');

    Route::get('/users/active', [UserController::class, 'active'])->name('users.active');
    Route::get('/users/inactive', [UserController::class, 'inactive'])->name('users.inactive');
    Route::get('/users/reject', [UserController::class, 'showReject'])->name('users.showReject');

    Route::post('/users/showActive', [UserController::class, 'showActive'])->name('showActive');
    Route::post('/users/showInactive', [UserController::class, 'showInactive'])->name('showInactive');
    Route::post('/users/showReject', [UserController::class, 'showRejected'])->name('showRejected');

    Route::post('/users/update-status/{id}', [UserController::class, 'updateStatus'])->name('users.update.status');
    Route::post('/users/update-user/{id}', [UserController::class, 'updateUser'])->name('users.update.user');
    Route::post('/users/action-reject/{id}', [UserController::class, 'actionReject'])->name('users.action.reject');
    Route::post('/users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    // product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Sosmed Routes
    // Route::get('/sosial-media', [SocialmediaController::class, "index"])->name('sosial-media');
    // Route::post('/sosial-media/insert', [SocialmediaController::class, "store"])->name('sosial-media.insert');
    // Route::post('/sosial-media/edit', [SocialmediaController::class, "edit"])->name('sosial-media.edit');
    // Route::post('/sosial-media/update/{id}', [SocialmediaController::class, "update"])->name('sosial-media.update');
    // Route::delete('/sosial-media/delete/{id}', [SocialmediaController::class, "destroy"])->name('sosial-media.delete');
});
