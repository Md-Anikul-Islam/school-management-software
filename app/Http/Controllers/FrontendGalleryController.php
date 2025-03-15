<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendGalleryController extends Controller
{
    public function gallery()
    {
        return view('frontend.pages.gallery');
    }
}
