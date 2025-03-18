<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('supplier-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Supplier List';
        if(auth()->user()->hasRole('Super Admin')){
            $suppliers = Supplier::all();
        } else {
            $suppliers = Supplier::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.supplier.index', compact('pageTitle', 'suppliers'));
    }

    public function create()
    {
        if (!Gate::allows('supplier-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.supplier.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company_name' => 'required',
                'supplier_name' => 'required',
            ]);

            $supplier = new Supplier();
            $supplier->company_name = $request->company_name;
            $supplier->supplier_name = $request->supplier_name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->school_id = Auth::user()->school_id ?? Auth::id();
            $supplier->created_by = Auth::user()->id;
            $supplier->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('supplier-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $supplier = Supplier::findOrFail($id);
        return view('admin.pages.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'company_name' => 'required',
                'supplier_name' => 'required',
            ]);

            $supplier = Supplier::findOrFail($id);
            $supplier->company_name = $request->company_name;
            $supplier->supplier_name = $request->supplier_name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->updated_by = Auth::user()->id;
            $supplier->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('supplier-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
