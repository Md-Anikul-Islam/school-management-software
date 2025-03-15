<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendPrivacyController extends Controller
{
    public function privacy()
    {
        return view('frontend.pages.privacy');
    }
}
