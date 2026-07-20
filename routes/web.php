<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;

Route::get('/sentry-test', function () {
    throw new Exception('PkmnNexus manual browser test');
});

Route::get('/under-development', function () { return view('frontend.under-development'); })->name('under-construction');

Route::get('/', [HomeController::class, 'index'])->name('home');