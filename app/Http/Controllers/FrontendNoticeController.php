<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendNoticeController extends Controller
{
    public function notice()
    {
        return view('frontend.pages.notice');
    }
}
