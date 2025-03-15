<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendTeachersController extends Controller
{
    public function teachers()
    {
        return view('frontend.pages.teachers');
    }
}
