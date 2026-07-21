<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\View\View;

use App\Models\Page;
use Spatie\Tags\Tag;

class TagController extends Controller
{
    public function show(string $tag)
    {
        $pageSeo = Page::where('slug', 'tag')->firstOrFail();
        return view('frontend.tag', [
            'pageSeo' => $pageSeo,
            'tag' => $tag
        ]);
    }
}
