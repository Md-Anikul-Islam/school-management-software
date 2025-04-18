<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('category-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Category List';
        if(auth()->user()->hasRole('Super Admin')) {
            $categories = Category::all();
        } else {
            $categories = Category::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.category.index', compact('pageTitle', 'categories'));
    }

    public function create()
    {
        if (!Gate::allows('category-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.category.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->school_id = Auth::user()->school_id ?? Auth::id();
            $category->created_by = Auth::user()->id;
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
        if (!Gate::allows('category-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $category = Category::find($id);
        return view('admin.pages.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $category = Category::find($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->school_id = Auth::user()->school_id ?? Auth::id();
            $category->updated_by = Auth::user()->id;
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
        if (!Gate::allows('category-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $category = Category::find($id);
            $category->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
