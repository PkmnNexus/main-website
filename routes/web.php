<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

Route::middleware(['under-construction'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

});

Route::get('/under-construction', function () { return view('frontend.under-construction'); })->name('under-construction');