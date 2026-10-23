<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SitemapController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/account/profile', 'frontend.user.profile')->name('account.profile');
    Route::view('/account/profile/edit', 'frontend.user.edit-profile')->name('account.profile.edit');
    
});

Route::middleware(['under-construction'])->group(function () {

    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
    Route::get('/sitemap', [SitemapController::class, 'show'])->name('sitemap');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/articles/category/video', [ArticleController::class, 'videos'])->name('articles.videos');
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
