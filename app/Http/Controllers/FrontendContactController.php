<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendContactController extends Controller
{
    public function contact()
    {
        return view('frontend.pages.contact');
    }
}
