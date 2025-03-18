<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Asset;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('purchase-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Purchase List';
        if(auth()->user()->hasRole('Super Admin')){
            $purchases = Purchase::all();
        } else{
            $purchases = Purchase::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.purchase.index', compact('pageTitle', 'purchases'));
    }

    public function create()
    {
        if (!Gate::allows('purchase-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $assets = Asset::all();
            $vendors = Vendor::all();
            $users = User::all();
        } else{
            $assets = Asset::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $vendors = Vendor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $users = User::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.purchase.add', compact('assets', 'vendors', 'users'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'asset_id' => 'required',
                'vendor_id' => 'required',
                'purchase_by' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'purchase_price' => 'required',
            ]);
            $purchase = new Purchase();
            $purchase->asset_id = $request->asset_id;
            $purchase->vendor_id = $request->vendor_id;
            $purchase->purchase_by = $request->purchase_by;
            $purchase->quantity = $request->quantity;
            $purchase->unit = $request->unit;
            $purchase->purchase_price = $request->purchase_price;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->service_date = $request->service_date;
            $purchase->expire_date = $request->expire_date;
            $purchase->school_id = Auth::user()->school_id ?? Auth::id();
            $purchase->created_by = Auth::id();
            $purchase->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if (!Gate::allows('purchase-show')) {
            return redirect()->route('unauthorized.action');
        }
        $purchase = Purchase::find($id);
        if(auth()->user()->hasRole('Super Admin')){
            $assets = Asset::all();
            $vendors = Vendor::all();
            $users = User::all();
        } else{
            $assets = Asset::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $vendors = Vendor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $users = User::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.purchase.show', compact('purchase', 'assets', 'vendors', 'users'));
    }

    public function edit($id)
    {
        if (!Gate::allows('purchase-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $purchase = Purchase::find($id);
        if(auth()->user()->hasRole('Super Admin')){
            $assets = Asset::all();
            $vendors = Vendor::all();
            $users = User::all();
        } else{
            $assets = Asset::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $vendors = Vendor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $users = User::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.purchase.edit', compact('purchase', 'assets', 'vendors', 'users'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'asset_id' => 'required',
                'vendor_id' => 'required',
                'purchase_by' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'purchase_price' => 'required',
            ]);
            $purchase = Purchase::find($id);
            $purchase->asset_id = $request->asset_id;
            $purchase->vendor_id = $request->vendor_id;
            $purchase->purchase_by = $request->purchase_by;
            $purchase->quantity = $request->quantity;
            $purchase->unit = $request->unit;
            $purchase->purchase_price = $request->purchase_price;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->service_date = $request->service_date;
            $purchase->expire_date = $request->expire_date;
            $purchase->school_id = Auth::user()->school_id ?? Auth::id();
            $purchase->updated_by = Auth::id();
            $purchase->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function is_approved($id)
    {
        try {
            $purchase = Purchase::find($id);
            $purchase->is_approved = !$purchase->is_approved;
            $purchase->save();
            toastr()->success('Status has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('purchase-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $purchase = Purchase::find($id);
            $purchase->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
