<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use LogicException;

class NavigationUrl
{
    public function for(array $item): string
    {
        $localizationEnabled = (bool) config('localization.enabled', false);

        $locale = $localizationEnabled
            ? request()->route('locale', app()->getLocale())
            : config('localization.default', 'en');

        if (isset($item['page_key'])) {
            return $this->pageUrl(
                $item['page_key'],
                $locale,
                $localizationEnabled,
                $item['route'] ?? null,
            );
        }

        if (isset($item['category_key'])) {
            return $this->categoryUrl(
                $item['category_key'],
                $locale,
                $localizationEnabled,
            );
        }

        $routeName = $item['route'];

        if (
            $localizationEnabled
            && $locale !== config('localization.default', 'en')
            && Route::has($routeName . '.' . $locale)
        ) {
            $routeName .= '.' . $locale;
        }

        return route($routeName);
    }

    public function isActive(array $item): bool
    {
        $patterns = $item['active_routes'] ?? [$item['route'] ?? ''];

        $locale = app()->getLocale();
        $localizationEnabled = (bool) config('localization.enabled', false);
        $defaultLocale = config('localization.default', 'en');

        foreach ($patterns as $pattern) {

            if (request()->routeIs($pattern)) {
                return true;
            }

            if (
                $localizationEnabled
                && $locale !== $defaultLocale
                && request()->routeIs($pattern . '.' . $locale)
            ) {
                return true;
            }

        }

        return false;
    }

    private function pageUrl(
        string $key,
        string $locale,
        bool $localizationEnabled,
        ?string $routeName,
    ): string {
        $page = Page::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        if (! $page) {
            throw new LogicException(
                "The navigation page [{$key}] does not exist or is inactive."
            );
        }

        if (! $localizationEnabled) {
            if ($routeName && Route::has($routeName)) {
                return route($routeName);
            }

            $slug = $page->getTranslation(
                'slug',
                config('localization.default', 'en'),
                false,
            );

            if (! filled($slug)) {
                throw new LogicException(
                    "The page [{$key}] has no default slug translation."
                );
            }

            return url('/' . ltrim($slug, '/'));
        }

        $slug = $page->getTranslation('slug', $locale, false);

        if (! filled($slug)) {
            throw new LogicException(
                "The page [{$key}] has no slug translation for locale [{$locale}]."
            );
        }

        return url('/' . $locale . '/' . ltrim($slug, '/'));
    }

    private function categoryUrl(
        string $key,
        string $locale,
        bool $localizationEnabled,
    ): string {
        $category = Category::query()
            ->where('key', $key)
            ->first();

        if (! $category) {
            throw new LogicException(
                "The navigation category [{$key}] does not exist."
            );
        }

        $slug = $category->getTranslation('slug', $locale, false);

        if (! filled($slug)) {
            throw new LogicException(
                "The category [{$key}] has no slug translation for locale [{$locale}]."
            );
        }

        $articleRoutes = config("localization.routes.{$locale}", []);

        $articlesPath = $articleRoutes['articles'] ?? 'articles';
        $categoryPath = $articleRoutes['category'] ?? 'category';

        $prefix = $localizationEnabled ? '/' . $locale : '';

        return url(
            $prefix . '/' . $articlesPath . '/' . $categoryPath . '/' . ltrim($slug, '/')
        );
    }
}