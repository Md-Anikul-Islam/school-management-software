<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveApply;
use App\Models\LeaveCategory;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;


class LeaveApplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('leave-apply-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Leave Apply';
        if (auth()->user()->role == 'Super Admin') {
            $leaveApplies = LeaveApply::all();
        } else {
            $leaveApplies = LeaveApply::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.leaveApply.index', compact('pageTitle', 'leaveApplies'));
    }

    public function create()
    {
        if (!Gate::allows('leave-apply-create')) {
            return redirect()->route('unauthorized.action');
        }
        $leaveCategories = LeaveCategory::all();
        $applicationTo = User::get();
        return view('admin.pages.leaveApply.add', compact('leaveCategories', 'applicationTo'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'application_to' => 'required',
                'leave_category_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
                'attachment' => 'required',
            ]);

            $leaveApply = new LeaveApply();
            $leaveApply->role_id = $request->role_id;
            $leaveApply->application_to = $request->application_to;
            $leaveApply->leave_category_id = $request->leave_category_id;
            $leaveApply->start_date = $request->start_date;
            $leaveApply->end_date = $request->end_date;
            $leaveApply->reason = $request->reason;
            if($request->hasFile('attachment')){
                $file = $request->file('attachment');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/leave-apply'), $fileName);
                $leaveApply->attachment = $fileName;
            }
            $leaveApply->school_id = Auth::user()->school_id ?? Auth::id();
            $leaveApply->created_by = Auth::id();
            $leaveApply->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('leave-apply-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $editorId = (int) $id;
        $leaveApply = LeaveApply::find($id);
        $leaveCategories = LeaveCategory::all();
        $applicationTo = User::get();
        return view('admin.pages.leaveApply.edit', compact('leaveApply', 'leaveCategories', 'applicationTo', 'editorId'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_id' => 'required',
                'application_to' => 'required',
                'leave_category_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
            ]);

            $leaveApply = LeaveApply::find($id);
            $leaveApply->role_id = $request->role_id;
            $leaveApply->application_to = $request->application_to;
            $leaveApply->leave_category_id = $request->leave_category_id;
            $leaveApply->start_date = $request->start_date;
            $leaveApply->end_date = $request->end_date;
            $leaveApply->reason = $request->reason;
            $fileName = $request->attachment ?? "";
            if($request->hasFile('attachment')){
                if (File::exists(public_path('uploads/leave-apply/' . $leaveApply->attachment))) {
                    File::delete(public_path('uploads/leave-apply/' . $leaveApply->attachment));
                }
                $file = $request->file('attachment');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/leave-apply'), $fileName);
                $leaveApply->attachment = $fileName;
            }
            $leaveApply->school_id =  Auth::user()->school_id ?? Auth::id();
            $leaveApply->updated_by = Auth::id();
            $leaveApply->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            if (!Gate::allows('leave-apply-delete')) {
                return redirect()->route('unauthorized.action');
            }
            $leaveApply = LeaveApply::find($id);
            if (File::exists(public_path('uploads/leave-apply/' . $leaveApply->attachment))) {
                File::delete(public_path('uploads/leave-apply/' . $leaveApply->attachment));
            }
            $leaveApply->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
