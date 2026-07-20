<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['under-construction'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

});

Route::get('/under-construction', function () { return view('frontend.under-construction'); })->name('under-construction');
