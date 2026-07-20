<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;

Route::get('/under-development', function () { return view('frontend.under-development'); })->name('under-construction');

Route::get('/', [HomeController::class, 'index'])->name('home');