<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SitemapController;

use App\Models\Article;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$registerFrontendRoutes = function () {

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
        Route::get('/articles/category/{category}', [ArticleController::class, 'category'])->name('articles.category');
        Route::get('/articles/tag/{tag}', [ArticleController::class, 'tag'])->name('articles.tag');
        Route::get('/articles/author/{user:slug}', [ArticleController::class, 'author'])->name('articles.author');
        Route::get('/articles/video/{slug}', [ArticleController::class, 'video'])->name('article.video');
        Route::get('/articles/{category}/{slug:slug}', [ArticleController::class, 'show'])->name('article.show');

        Route::get('/about', [PageController::class, 'show'])->defaults('page', 'about')->name('page.about');
        Route::get('/disclaimer', [PageController::class, 'show'])->defaults('page', 'disclaimer')->name('page.disclaimer');
        Route::get('/privacy-policy', [PageController::class, 'show'])->defaults('page', 'privacy-policy')->name('page.privacy-policy');
        Route::get('/terms-and-conditions', [PageController::class, 'show'])->defaults('page', 'terms-and-conditions')->name('page.terms-and-conditions');
        Route::get('/cookie-policy', [PageController::class, 'show'])->defaults('page', 'cookie-policy')->name('page.cookie-policy');

    });

    Route::get('/under-construction', function () {

        return view('frontend.under-construction');

    })->name('under-construction');

};

Route::post('/language', function (Request $request) {

    abort_unless(config('localization.enabled'), 404);

    $locales = array_keys(config('localization.locales', []));

    $validated = $request->validate([
        'locale' => ['required', 'string', 'in:' . implode(',', $locales)],
    ]);

    $request->session()->put('locale', $validated['locale']);

    $previousUrl = url()->previous();
    $previousPath = parse_url($previousUrl, PHP_URL_PATH) ?: '/';
    $previousQuery = parse_url($previousUrl, PHP_URL_QUERY);

    $segments = explode('/', trim($previousPath, '/'));

    $currentLocale = config('localization.default', 'en');

    if (isset($segments[0]) && in_array($segments[0], $locales, true)) {
        $currentLocale = array_shift($segments);
    }

    $targetLocale = $validated['locale'];

    // Translate article category and preserve the article slug.
    if (
        count($segments) === 3
        && $segments[0] === 'articles'
        && ! in_array($segments[1], ['category', 'tag', 'author', 'video'], true)
    ) {
        [$articlesPath, $categorySlug, $articleSlug] = $segments;

        $article = Article::query()
            ->where('slug', $articleSlug)
            ->whereHas('category', fn ($query) => $query
                ->where("slug->{$currentLocale}", $categorySlug))
            ->with('category')
            ->first();

        if ($article) {
            $translatedCategorySlug = $article->category
                ->getTranslation('slug', $targetLocale);

            $segments = [
                $articlesPath,
                $translatedCategorySlug,
                $articleSlug,
            ];
        }
    }

    // Translate category overview URLs.
    if (
        count($segments) === 3
        && $segments[0] === 'articles'
        && $segments[1] === 'category'
        && $segments[2] !== 'video'
    ) {
        $category = Category::query()
            ->where("slug->{$currentLocale}", $segments[2])
            ->first();

        if ($category) {
            $segments[2] = $category->getTranslation('slug', $targetLocale);
        }
    }

    $path = implode('/', $segments);

    $isAdminPath = isset($segments[0]) && $segments[0] === 'admin';

    if ($isAdminPath) {
        $targetPath = '/' . $path;
    } else {
        $targetPath = '/' . $targetLocale;

        if ($path !== '' && $path !== 'language') {
            $targetPath .= '/' . $path;
        }
    }

    $targetUrl = url($targetPath);

    if ($previousQuery) {
        $targetUrl .= '?' . $previousQuery;
    }

    return redirect()->to($targetUrl);

})->name('language.switch');

if (config('localization.enabled')) {

    Route::get('/', function () {

        return redirect('/' . config('localization.default', 'en'));

    });

    Route::prefix('{locale}')->group(function () use ($registerFrontendRoutes) {

        $registerFrontendRoutes();

        require base_path('vendor/laravel/fortify/routes/routes.php');

    });

} else {

    $registerFrontendRoutes();

    require base_path('vendor/laravel/fortify/routes/routes.php');

}