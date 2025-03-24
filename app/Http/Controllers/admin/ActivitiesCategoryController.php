<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ActivitiesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ActivitiesCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('activities-category-list',)) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Activities Category';
        if(auth()->user()->can('Super Admin')) {
            $activities = ActivitiesCategory::all();
        } else{
            $activities = ActivitiesCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.activitiesCategory.index', compact('activities', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('activities-category-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.activitiesCategory.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'font_awesome_icon' => 'required',
            ]);

            $category = new ActivitiesCategory();
            $category->title = $request->title;
            $category->font_awesome_icon = $request->font_awesome_icon;
            $category->school_id = Auth::user()->school_id ?? Auth::id();
            $category->created_by = Auth::id();
            $category->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('activities-category-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $category = ActivitiesCategory::find($id);
        return view('admin.pages.activitiesCategory.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'font_awesome_icon' => 'required',
            ]);

            $category = ActivitiesCategory::find($id);
            $category->title = $request->title;
            $category->font_awesome_icon = $request->font_awesome_icon;
            $category->school_id = Auth::user()->school_id ?? Auth::id();
            $category->created_by = Auth::id();
            $category->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('activities-category-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $category = ActivitiesCategory::find($id);
            $category->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
