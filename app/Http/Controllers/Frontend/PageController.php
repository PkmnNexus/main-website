<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(Page $page): View
    {
        abort_unless($page->is_active, 404);

        return view('frontend.page.show', [
            'page' => $page,
            'pageSeo' => $page,
        ]);
    }
}