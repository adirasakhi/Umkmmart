<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.index');
});
Route::get('/shop', function () {
    return view('LandingPage.shop');
});
Route::get('/detail', function () {
    return view('LandingPage.Detail');
});
Route::get('/404', function () {
    return view('LandingPage.404');
});
Route::get('/chart', function () {
    return view('LandingPage.chart');
});
Route::get('/testimoni', function () {
    return view('LandingPage.testimoni');
});
Route::get('/contact', function () {
    return view('LandingPage.contact');
});
