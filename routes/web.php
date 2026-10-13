<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\PageController;

use Illuminate\Support\Facades\Route;

Route::middleware(['under-construction'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/articles/category/{category:slug}', [ArticleController::class, 'category'])->name('articles.category');
    Route::get('/articles/tag/{tag}', [ArticleController::class, 'tag'])->name('articles.tag');
    Route::get('/articles/author/{user:slug}', [ArticleController::class, 'author'])->name('articles.author');
    Route::get('/articles/video/{slug}', [ArticleController::class, 'video'])->name('article.video');
    Route::get('/articles/{category:slug}/{slug:slug}', [ArticleController::class, 'show'])->name('article.show');

    Route::get('/about', [PageController::class, 'show'])->defaults('page', 'about')->name('page.about');
    Route::get('/disclaimer', [PageController::class, 'show'])->defaults('page', 'disclaimer')->name('page.disclaimer');
    Route::get('/privacy-policy', [PageController::class, 'show'])->defaults('page', 'privacy-policy')->name('page.privacy-policy');
    Route::get('/terms-and-conditions', [PageController::class, 'show'])->defaults('page', 'terms-and-conditions')->name('page.terms-and-conditions');
    Route::get('/cookie-policy', [PageController::class, 'show'])->defaults('page', 'cookie-policy')->name('page.cookie-policy');

});

Route::get('/under-construction', function () { return view('frontend.under-construction'); })->name('under-construction');
