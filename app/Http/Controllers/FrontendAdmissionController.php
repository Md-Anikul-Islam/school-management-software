<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendAdmissionController extends Controller
{

    public function admission()
    {
        return view('frontend.pages.admission');
    }
}
