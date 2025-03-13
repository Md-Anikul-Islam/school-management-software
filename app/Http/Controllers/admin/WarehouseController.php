<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('warehouse-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Warehouse List';
        if (auth()->user()->hasRole('Super Admin')) {
            $warehouses = Warehouse::latest()->get();
        } else {
            $warehouses = Warehouse::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.warehouse.index', compact('pageTitle', 'warehouses'));
    }

    public function create()
    {
        return view('admin.pages.warehouse.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'code' => 'required',
                'address' => 'required',
            ]);

            $warehouse = new Warehouse();
            $warehouse->name = $request->name;
            $warehouse->code = $request->code;
            $warehouse->email = $request->email;
            $warehouse->phone = $request->phone;
            $warehouse->address = $request->address;
            $warehouse->school_id = Auth::user()->school_id ?? Auth::id();
            $warehouse->created_by = Auth::user()->id;
            $warehouse->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $warehouse = Warehouse::find($id);
        return view('admin.pages.warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'code' => 'required',
                'address' => 'required',
            ]);

            $warehouse = Warehouse::find($id);
            $warehouse->name = $request->name;
            $warehouse->code = $request->code;
            $warehouse->email = $request->email;
            $warehouse->phone = $request->phone;
            $warehouse->address = $request->address;
            $warehouse->school_id = Auth::user()->school_id ?? Auth::id();
            $warehouse->updated_by = Auth::user()->id;
            $warehouse->save();
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
            $warehouse = Warehouse::find($id);
            $warehouse->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
