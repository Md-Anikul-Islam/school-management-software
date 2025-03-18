<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class AssetCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('asset-category-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Asset Category';
        if(auth()->user()->hasRole('Super Admin')){
            $assetCategories = AssetCategory::all();
        } else {
            $assetCategories = AssetCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.assetCategory.index', compact('assetCategories', 'pageTitle'));
    }

    public function create()
    {
        if(!Gate::allows('asset-category-create')){
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.assetCategory.add');
    }

    public function store(Request $request)
    {
        try{
            $assetCategory = new AssetCategory();
            $assetCategory->category = $request->category;
            $assetCategory->school_id = Auth::user()->school_id;
            $assetCategory->created_by = Auth::id();
            $assetCategory->updated_by = Auth::id();
            $assetCategory->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('asset-category-edit')){
            return redirect()->route('unauthorized.action');
        }
        $assetCategory = AssetCategory::find($id);
        return view('admin.pages.assetCategory.edit', compact('assetCategory'));
    }

    public function update(Request $request, $id)
    {
        try{
            $assetCategory = AssetCategory::find($id);
            $assetCategory->category = $request->category;
            $assetCategory->updated_by = Auth::id();
            $assetCategory->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('asset-category-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $assetCategory = AssetCategory::find($id);
            $assetCategory->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
