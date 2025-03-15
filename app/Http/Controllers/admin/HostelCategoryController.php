<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\HostelCategory;
use App\Models\Hostel;

class HostelCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('hostel-category-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $hostelCategories = HostelCategory::latest()->get();
        } else {
            $hostelCategories = HostelCategory::where('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.hostelCategory.index', compact('hostelCategories'));
    }

    public function create()
    {
        if (!Gate::allows('hostel-category-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $hostels = Hostel::all();
        } else {
            $hostels = Hostel::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.hostelCategory.add', compact('hostels'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'hostel_id' => 'required',
                'class_type' => 'required',
                'hostel_fee' => 'required',
            ]);
            $hostelCategory = new HostelCategory();
            $hostelCategory->hostel_id = $request->hostel_id;
            $hostelCategory->class_type = $request->class_type;
            $hostelCategory->hostel_fee = $request->hostel_fee;
            $hostelCategory->note = $request->note;
            $hostelCategory->school_id = Auth::user()->school_id ?? Auth::id();
            $hostelCategory->created_by = Auth::user()->id;
            $hostelCategory->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $hostelCategory = HostelCategory::find($id);
        if(auth()->user()->hasRole('Super Admin')){
            $hostels = Hostel::all();
        } else {
            $hostels = Hostel::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.hostelCategory.edit', compact('hostelCategory', 'hostels'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'hostel_id' => 'required',
                'class_type' => 'required',
                'hostel_fee' => 'required',
            ]);
            $hostelCategory = HostelCategory::find($id);
            $hostelCategory->hostel_id = $request->hostel_id;
            $hostelCategory->class_type = $request->class_type;
            $hostelCategory->hostel_fee = $request->hostel_fee;
            $hostelCategory->note = $request->note;
            $hostelCategory->school_id = Auth::user()->school_id ?? Auth::id();
            $hostelCategory->updated_by = Auth::user()->id;
            $hostelCategory->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try{
            $hostelCategory = HostelCategory::find($id);
            $hostelCategory->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
