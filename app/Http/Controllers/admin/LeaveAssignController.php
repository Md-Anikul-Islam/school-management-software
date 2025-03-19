<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveAssign;
use App\Models\LeaveCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LeaveAssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('leave-assign-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = "Leave Assign List";
        if (auth()->user()->role == 'Super Admin') {
            $leaveAssigns = LeaveAssign::all();
        } else {
            $leaveAssigns = LeaveAssign::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.leaveAssign.index', compact('leaveAssigns', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('leave-assign-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->role == 'Super Admin') {
            $leaveCategories = LeaveCategory::all();
        } else {
            $leaveCategories = LeaveCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.leaveAssign.add', compact('leaveCategories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'leave_category_id' => 'required',
                'number_of_days' => 'required',
            ]);

            $leaveAssign = new LeaveAssign();
            $leaveAssign->role_id = $request->role_id;
            $leaveAssign->leave_category_id = $request->leave_category_id;
            $leaveAssign->number_of_days = $request->number_of_days;
            $leaveAssign->school_id =  Auth::user()->school_id ?? Auth::id();
            $leaveAssign->created_by = Auth::id();
            $leaveAssign->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('leave-assign-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $leaveAssign = LeaveAssign::find($id);
        if (auth()->user()->role == 'Super Admin') {
            $leaveCategories = LeaveCategory::all();
        } else {
            $leaveCategories = LeaveCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.leaveAssign.edit', compact('leaveAssign', 'leaveCategories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'leave_category_id' => 'required',
                'number_of_days' => 'required',
            ]);

            $leaveAssign = LeaveAssign::find($id);
            $leaveAssign->role_id = $request->role_id;
            $leaveAssign->leave_category_id = $request->leave_category_id;
            $leaveAssign->number_of_days = $request->number_of_days;
            $leaveAssign->school_id =  Auth::user()->school_id ?? Auth::id();
            $leaveAssign->updated_by = Auth::id();
            $leaveAssign->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->route('leave-assign.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('leave-assign-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $leaveAssign = LeaveAssign::find($id);
            $leaveAssign->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

}
