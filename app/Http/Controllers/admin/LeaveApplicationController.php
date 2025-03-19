<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
class LeaveApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('leave-application-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = "Leave Application List";
        $leaveApplications = LeaveApply::all();
        return view('admin.pages.leaveApplication.index', compact('pageTitle', 'leaveApplications'));
    }

    public function show($id)
    {
        if (!Gate::allows('leave-application-show')) {
            return redirect()->route('unauthorized.action');
        }
        $leaveApply = LeaveApply::find($id);
        return view('admin.pages.leaveApplication.show', compact('leaveApply'));
    }

    public function pdf($id)
    {
        if (!Gate::allows('leave-application-show')) {
            return redirect()->route('unauthorized.action');
        }
        $leaveApply = LeaveApply::find($id);
        $pdf = PDF::loadView('admin.pages.leaveApplication.pdf', compact('leaveApply'));
        return $pdf->download('leave_application_details.pdf');
    }

    public function approve($id)
    {
        if (!Gate::allows('leave-application-approve')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $leaveApplication = LeaveApply::find($id);
            $leaveApplication->status = 1;
            $leaveApplication->save();
            toastr()->success('Leave application approved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function decline($id)
    {
        if (!Gate::allows('leave-application-decline')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $leaveApplication = LeaveApply::find($id);
            $leaveApplication->status = 2;
            $leaveApplication->save();
            toastr()->success('Leave application declined successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
