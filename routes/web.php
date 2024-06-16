<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SocialmediaController;


Route::get('/dashboard', function () {
    return view('pages.dashboard.content-dashboard');
});
Route::get('/produk', function () {
    return view('pages.dashboard.produk');
});
Route::get('/create-produk', function () {
    return view('pages.dashboard.createProduk');
});
Route::get('/', function () {
    return view('pages.Landing.index');
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
Route::post('/kategori/insert', [CategoryController::class, "store"])->name('kategori.insert');
Route::post('/kategori/edit', [CategoryController::class, "edit"])->name('kategori.edit');
Route::post('/kategori/update/{id}', [CategoryController::class, "update"])->name('kategori.update');
Route::delete('/kategori/delete/{id}', [CategoryController::class, "destroy"])->name('category.delete');

Route::get('/sosial-media', [SocialmediaController::class, "index"])->name('sosial-media');
Route::post('/sosial-media/insert', [SocialmediaController::class, "store"])->name('sosial-media.insert');


