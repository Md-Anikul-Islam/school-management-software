<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('product-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Product List';
        if(auth()->user()->hasRole('Super Admin')) {
            $products = Product::all();
        } else {
            $products = Product::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.product.index', compact('pageTitle', 'products'));
    }

    public function create()
    {
        if (!Gate::allows('product-create')) {
            return redirect()->route('unauthorized.action');
        }
        $categories = Category::all();
        return view('admin.pages.product.add', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'buying_price' => 'required',
                'selling_price' => 'required',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->description = $request->description;
            $product->school_id = Auth::user()->school_id ?? Auth::id();
            $product->created_by = Auth::user()->id;
            $product->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('product-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $product = Product::find($id);
        if(auth()->user()->hasRole('Super Admin')) {
            $categories = Category::all();
        } else {
            $categories = Category::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'buying_price' => 'required',
                'selling_price' => 'required',
            ]);

            $product = Product::find($id);
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->description = $request->description;
            $product->school_id = Auth::user()->school_id ?? Auth::id();
            $product->updated_by = Auth::user()->id;
            $product->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('product-delete')){
            return redirect()->route('unauthorized.action');
        }
        try {
            $product = Product::find($id);
            $product->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
