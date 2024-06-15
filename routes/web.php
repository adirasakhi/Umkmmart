<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;



Route::get('/dashboard', function () {
    return view('pages.dashboard.content-dashboard');
});
Route::get('/produk', function () {
    return view('pages.dashboard.product');
});
Route::get('/create-produk', function () {
    return view('pages.dashboard.createProduk');
});
Route::get('/', function () {
    return view('pages.Landing.index')->name('home');
});
Route::get('/shop', function () {
    return view('pages.Landing.shop');
});

Route::get('/detail', function () {
    return view('pages.Landing.Detail');
});
Route::get('/404', function () {
    return view('pages.Landing.404');
});
Route::get('/chart', function () {
    return view('pages.Landing.chart');
});
Route::get('/testimoni', function () {
    return view('pages.Landing.testimoni');
});
Route::get('/contact', function () {
    return view('pages.Landing.contact');
});
Route::get('/kategori', [CategoryController::class, "index"])->name('kategori');
Route::post('/kategori/insert', [CategoryController::class, "store"])->name('kategori.add');
Route::post('/kategori/edit', [CategoryController::class, "edit"])->name('kategori.edit');
Route::post('/kategori/update/{id}', [CategoryController::class, "update"])->name('kategori.update');
Route::delete('/kategori/delete/{id}', [CategoryController::class, "destroy"])->name('category.delete');

// User routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Auth routes
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
