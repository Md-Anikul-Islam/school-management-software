<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('vendor-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = "Vendor List";
        if(auth()->user()->hasRole('Super Admin')) {
            $vendors = Vendor::all();
        } else {
            $vendors = Vendor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.vendor.index', compact('vendors', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('vendor-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.vendor.add');
    }

    public function store(Request $request)
    {
        try{
            $vendor = new Vendor();
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->contact_name = $request->contact_name;
            $vendor->school_id = Auth::user()->school_id ?? Auth::id();
            $vendor->created_by = Auth::user()->id;
            $vendor->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('vendor-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $vendor = Vendor::find($id);
        return view('admin.pages.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        try{
            $vendor = Vendor::find($id);
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->contact_name = $request->contact_name;
            $vendor->school_id = Auth::user()->school_id ?? Auth::id();
            $vendor->updated_by = Auth::user()->id;
            $vendor->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('vendor-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $vendor = Vendor::find($id);
            $vendor->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
