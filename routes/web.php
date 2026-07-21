<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['under-construction'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/tag/{tag}', [TagController::class, 'show'])->name('tag.show');
    Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

    Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/{category}/{slug}', [ArticleController::class, 'show'])->name('article.show');

});

Route::get('/under-construction', function () { return view('frontend.under-construction'); })->name('under-construction');
