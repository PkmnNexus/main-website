<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $pageSeo = Page::where('slug', 'home')->firstOrFail();

        return view('frontend.home', compact('pageSeo'));
    }
}
