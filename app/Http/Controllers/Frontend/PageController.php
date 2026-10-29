<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(Request $request, ?string $pageSlug = null): View
    {
        if (config('localization.enabled', false)) {
            $locale = $request->route('locale') ?? app()->getLocale();
            abort_unless(
                array_key_exists($locale, config('localization.locales', [])),
                404,
            );
        } else {
            $locale = config('localization.default', 'en');
        }

        app()->setLocale($locale);

        $pageKey = $request->route('page');
        $pageSlug = $pageSlug ?? $request->route('pageSlug');

        if (filled($pageKey)) {
            $page = Page::query()
                ->where('key', $pageKey)
                ->first();
        } else {
            abort_unless(filled($pageSlug), 404, 'Page slug is missing.');

            $page = Page::query()
                ->where("slug->{$locale}", $pageSlug)
                ->first();

            abort_if(
                ! $page,
                404,
                "Page not found. Locale: {$locale}; slug: {$pageSlug}; route: {$request->route()->getName()}",
            );
        }

        abort_unless($page && $page->is_active, 404, 'Page is missing or inactive.');

        return view('frontend.page.show', [
            'page' => $page,
            'pageSeo' => $page,
        ]);
    }
}