<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\View\View;

use App\Models\Page;

class HomeController extends Controller
{
    public function index(): View
    {
        $pageSeo = Page::where('slug', 'home')->firstOrFail();
        
        return view('frontend.home', compact('pageSeo'));
    }
}
