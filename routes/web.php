<?php

use Illuminate\Support\Facades\Route;


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
