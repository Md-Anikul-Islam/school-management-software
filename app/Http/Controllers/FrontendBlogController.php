<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendBlogController extends Controller
{
    public function blog()
    {
        return view('frontend.pages.blog');
    }
}
