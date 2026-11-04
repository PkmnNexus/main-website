<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SitemapController;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$registerFrontendRoutes = function () {

    Route::middleware(['under-construction'])->group(function () {

        Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
        Route::get('/sitemap', [SitemapController::class, 'show'])->name('sitemap');

        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::get('/about', [PageController::class, 'show'])->defaults('page', 'about')->name('about');
        Route::get('/disclaimer', [PageController::class, 'show'])->defaults('page', 'disclaimer')->name('disclaimer');
        Route::get('/privacy-policy', [PageController::class, 'show'])->defaults('page', 'privacy-policy')->name('privacy-policy');
        Route::get('/terms-and-conditions', [PageController::class, 'show'])->defaults('page', 'terms-and-conditions')->name('terms-and-conditions');
        Route::get('/cookie-policy', [PageController::class, 'show'])->defaults('page', 'cookie-policy')->name('cookie-policy');

    });

    Route::get('/under-construction', function () {

        return view('frontend.under-construction');

    })->name('under-construction');

};

$registerAccountRoutes = function (string $locale, bool $localized = true) {

    $accountRoutes = config("localization.routes.{$locale}.account", []);

    $nameSuffix = $localized && $locale !== config('localization.default', 'en')
        ? ".{$locale}"
        : '';

    Route::middleware(['auth', 'verified'])->group(function () use (
        $accountRoutes,
        $nameSuffix,
    ) {

        Route::view('/' . ($accountRoutes['profile'] ?? 'account/profile'), 'frontend.user.profile')
            ->name('account.profile' . $nameSuffix);

        Route::view('/' . ($accountRoutes['edit-profile'] ?? 'account/profile/edit'), 'frontend.user.edit-profile')
            ->name('account.profile.edit' . $nameSuffix);

    });

};

$registerArticleRoutes = function (string $locale, bool $localized = true) {

    $articleRoutes = config("localization.routes.{$locale}", []);

    $articlesPath = $articleRoutes['articles'] ?? 'articles';
    $categoryPath = $articleRoutes['category'] ?? 'category';
    $tagPath = $articleRoutes['tag'] ?? 'tag';
    $authorPath = $articleRoutes['author'] ?? 'author';
    $videoPath = $articleRoutes['video'] ?? 'video';

    $nameSuffix = $localized && $locale !== config('localization.default', 'en')
        ? ".{$locale}"
        : '';

    $registerRoutes = function () use (
        $articlesPath,
        $categoryPath,
        $tagPath,
        $authorPath,
        $videoPath,
        $nameSuffix,
    ) {

        Route::middleware(['under-construction'])->group(function () use (
            $articlesPath,
            $categoryPath,
            $tagPath,
            $authorPath,
            $videoPath,
            $nameSuffix,
        ) {

            Route::get("/{$articlesPath}", [ArticleController::class, 'index'])
                ->name('article.index' . $nameSuffix);

            Route::get("/{$articlesPath}/{$categoryPath}/video", [ArticleController::class, 'videos'])
                ->name('articles.videos' . $nameSuffix);

            Route::get("/{$articlesPath}/{$categoryPath}/{category}", [ArticleController::class, 'category'])
                ->name('articles.category' . $nameSuffix);

            Route::get("/{$articlesPath}/{$tagPath}/{tag}", [ArticleController::class, 'tag'])
                ->name('articles.tag' . $nameSuffix);

            Route::get("/{$articlesPath}/{$authorPath}/{user:slug}", [ArticleController::class, 'author'])
                ->name('articles.author' . $nameSuffix);

            Route::get("/{$articlesPath}/{$videoPath}/{slug}", [ArticleController::class, 'video'])
                ->name('article.video' . $nameSuffix);

            Route::get("/{$articlesPath}/{category}/{slug:slug}", [ArticleController::class, 'show'])
                ->name('article.show' . $nameSuffix);

        });

    };

    if ($localized) {
        Route::prefix($locale)->group($registerRoutes);
    } else {
        $registerRoutes();
    }

};

Route::post('/language', function (Request $request) {

    abort_unless(config('localization.enabled', false), 404);

    $locales = array_keys(config('localization.locales', []));

    abort_if(empty($locales), 404);

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

    $currentRoutes = config("localization.routes.{$currentLocale}", []);
    $targetRoutes = config("localization.routes.{$targetLocale}", []);

    $currentArticlesPath = $currentRoutes['articles'] ?? 'articles';
    $currentCategoryPath = $currentRoutes['category'] ?? 'category';
    $currentTagPath = $currentRoutes['tag'] ?? 'tag';
    $currentAuthorPath = $currentRoutes['author'] ?? 'author';
    $currentVideoPath = $currentRoutes['video'] ?? 'video';

    $targetArticlesPath = $targetRoutes['articles'] ?? 'articles';
    $targetCategoryPath = $targetRoutes['category'] ?? 'category';
    $targetTagPath = $targetRoutes['tag'] ?? 'tag';
    $targetAuthorPath = $targetRoutes['author'] ?? 'author';
    $targetVideoPath = $targetRoutes['video'] ?? 'video';

    // Translate account URLs.
    $currentAccountRoutes = $currentRoutes['account'] ?? [];
    $targetAccountRoutes = $targetRoutes['account'] ?? [];

    $currentProfilePath = $currentAccountRoutes['profile'] ?? 'account/profile';
    $currentEditProfilePath = $currentAccountRoutes['edit-profile'] ?? 'account/profile/edit';

    $targetProfilePath = $targetAccountRoutes['profile'] ?? 'account/profile';
    $targetEditProfilePath = $targetAccountRoutes['edit-profile'] ?? 'account/profile/edit';

    $currentPath = implode('/', $segments);

    if ($currentPath === $currentProfilePath) {
        $segments = explode('/', $targetProfilePath);
    } elseif ($currentPath === $currentEditProfilePath) {
        $segments = explode('/', $targetEditProfilePath);
    }

    // Translate article detail URLs.
    if (
        count($segments) === 3
        && $segments[0] === $currentArticlesPath
        && ! in_array($segments[1], [
            $currentCategoryPath,
            $currentTagPath,
            $currentAuthorPath,
            $currentVideoPath,
        ], true)
    ) {
        [$articlesSegment, $categorySlug, $articleSlug] = $segments;

        $article = Article::query()
            ->where("slug->{$currentLocale}", $articleSlug)
            ->whereHas('category', fn ($query) => $query
                ->where("slug->{$currentLocale}", $categorySlug))
            ->with('category')
            ->first();

        if ($article) {
            $translatedCategorySlug = $article->category
                ->getTranslation('slug', $targetLocale, false);

            $translatedArticleSlug = $article
                ->getTranslation('slug', $targetLocale, false);

            $segments = [
                $targetArticlesPath,
                filled($translatedCategorySlug) ? $translatedCategorySlug : $categorySlug,
                filled($translatedArticleSlug) ? $translatedArticleSlug : $articleSlug,
            ];
        }
    }

    // Translate article overview URLs.
    if (isset($segments[0]) && $segments[0] === $currentArticlesPath) {
        $segments[0] = $targetArticlesPath;
    }

    // Translate category overview URLs.
    if (
        count($segments) === 3
        && $segments[0] === $targetArticlesPath
        && $segments[1] === $currentCategoryPath
        && $segments[2] !== 'video'
    ) {
        $category = Category::query()
            ->where("slug->{$currentLocale}", $segments[2])
            ->first();

        if ($category) {
            $translatedSlug = $category->getTranslation('slug', $targetLocale, false);

            if (filled($translatedSlug)) {
                $segments[2] = $translatedSlug;
            }
        }

        $segments[1] = $targetCategoryPath;
    }

    // Translate tag, author and video route segments.
    if (isset($segments[1]) && $segments[0] === $targetArticlesPath) {
        $segments[1] = match ($segments[1]) {
            $currentTagPath => $targetTagPath,
            $currentAuthorPath => $targetAuthorPath,
            $currentVideoPath => $targetVideoPath,
            default => $segments[1],
        };

        if ($segments[1] === $targetCategoryPath && ($segments[2] ?? null) === 'video') {
            $segments[2] = 'video';
        }
    }

    // Translate individual page URLs.
    // The key fallback also supports the existing fixed page routes.
    if (count($segments) === 1) {
        $page = Page::query()
            ->where(function ($query) use ($segments, $currentLocale) {
                $query
                    ->where("slug->{$currentLocale}", $segments[0])
                    ->orWhere('key', $segments[0]);
            })
            ->first();

        if ($page) {
            $translatedSlug = $page->getTranslation('slug', $targetLocale, false);

            if (filled($translatedSlug)) {
                $segments[0] = $translatedSlug;
            }
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

if (config('localization.enabled', false)) {

    Route::get('/', function () {
        return redirect('/' . config('localization.default', 'en'));
    });

    foreach (array_keys(config('localization.locales', [])) as $locale) {
        $registerArticleRoutes($locale);

        Route::prefix($locale)->group(function () use ($registerAccountRoutes, $locale) {
            $registerAccountRoutes($locale);
        });
    }

    Route::prefix('{locale}')->group(function () use ($registerFrontendRoutes) {

        $registerFrontendRoutes();

        require base_path('vendor/laravel/fortify/routes/routes.php');

        // Resolve translated page slugs after the explicit frontend and Fortify routes.
        Route::middleware(['under-construction'])
            ->get('/{pageSlug}', [PageController::class, 'show'])
            ->where('pageSlug', '[A-Za-z0-9][A-Za-z0-9\-]*')
            ->name('page.translated');

    });

} else {

    $registerFrontendRoutes();

    $registerAccountRoutes(config('localization.default', 'en'), false);

    $registerArticleRoutes(config('localization.default', 'en'), false);

    require base_path('vendor/laravel/fortify/routes/routes.php');

    // Without localization, resolve page slugs using the default app locale.
    Route::middleware(['under-construction'])
        ->get('/{pageSlug}', [PageController::class, 'show'])
        ->where('pageSlug', '[A-Za-z0-9][A-Za-z0-9\-]*')
        ->name('page.translated');

}