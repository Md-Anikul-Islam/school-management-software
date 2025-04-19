<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FeeTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FeeTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('feetypes-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Fee Types';
        if(auth()->user()->hasRole('Super Admin')) {
            $feeTypes = FeeTypes::all();
        } else {
            $feeTypes = FeeTypes::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.feeTypes.index', compact('pageTitle', 'feeTypes'));
    }

    public function create()
    {
        if (!Gate::allows('feetypes-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.feeTypes.add');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'fee_type' => 'required',
                'note' => 'nullable',
            ]);
            $feeType = new FeeTypes();
            $feeType->fee_type = $request->fee_type;
            $feeType->note = $request->note;
            $feeType->is_monthly = $request->has('is_monthly') ? 1 : 0;
            $feeType->school_id = Auth::user()->school_id ?? Auth::id();
            $feeType->created_by = Auth::id();
            $feeType->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('feetypes-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $feeType = FeeTypes::find($id);
        return view('admin.pages.feeTypes.edit', compact('feeType'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'fee_type' => 'required',
                'note' => 'nullable',
            ]);
            $feeType = FeeTypes::find($id);
            $feeType->fee_type = $request->fee_type;
            $feeType->note = $request->note;
            $feeType->is_monthly = $request->has('is_monthly') ? 1 : 0;
            $feeType->school_id = Auth::user()->school_id ?? Auth::id();
            $feeType->updated_by = Auth::id();
            $feeType->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('feetypes-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $feeType = FeeTypes::find($id);
            $feeType->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }
}
