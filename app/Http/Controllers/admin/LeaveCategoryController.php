<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LeaveCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('leave-category-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Leave Category';
        if (auth()->user()->role == 'Super Admin') {
            $leaveCategories = LeaveCategory::all();
        } else {
            $leaveCategories = LeaveCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.leaveCategory.index', compact('pageTitle', 'leaveCategories'));
    }

    public function create()
    {
        if(!Gate::allows('leave-category-create')){
            return redirect()->route('unauthorized.action');
        }
        $pageTitle = 'Add Leave Category';
        return view('admin.pages.leaveCategory.add', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'category' => 'required',
            ]);

            $leaveCategory = new LeaveCategory();
            $leaveCategory->category = $request->category;
            $leaveCategory->school_id = Auth::user()->school_id;
            $leaveCategory->created_by = Auth::id();
            $leaveCategory->updated_by = Auth::id();
            $leaveCategory->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('leave-category-edit')){
            return redirect()->route('unauthorized.action');
        }
        $pageTitle = 'Edit Leave Category';
        $leaveCategory = LeaveCategory::find($id);
        return view('admin.pages.leaveCategory.edit', compact('pageTitle', 'leaveCategory'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'category' => 'required',
            ]);

            $leaveCategory = LeaveCategory::find($id);
            $leaveCategory->category = $request->category;
            $leaveCategory->updated_by = Auth::id();
            $leaveCategory->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('leave-category-delete')){
            return redirect()->route('unauthorized.action');
        }
        try{
            $leaveCategory = LeaveCategory::find($id);
            $leaveCategory->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
