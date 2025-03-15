<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendEventController extends Controller
{
    public function event()
    {
        return view('frontend.pages.event');
    }
}
