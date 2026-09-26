<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ArticleController;

use Illuminate\Support\Facades\Route;

Route::middleware(['under-construction'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/articles/category/{category:slug}', [ArticleController::class, 'category'])->name('articles.category');
    Route::get('/articles/tag/{tag}', [ArticleController::class, 'tag'])->name('articles.tag');
    Route::get('/articles/{category:slug}/{slug:slug}', [ArticleController::class, 'show'])->name('article.show');

});

Route::get('/under-construction', function () { return view('frontend.under-construction'); })->name('under-construction');
