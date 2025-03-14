<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\HostelMember;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HostelMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('hostel-member-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $students = Student::all();
        } else {
            $students = Student::where('school_id', Auth()->user()->school_id)->orWhere('school_id', Auth::id()->school_id)->get();
        }
    }
}
