<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\AssetAssignment;
use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


class AssetAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('asset-assignment-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Asset Assignment List';
        if(auth()->user()->hasRole('Super Admin')){
            $assetAssignments = AssetAssignment::all();
        }
        else{
            $assetAssignments = AssetAssignment::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.assetAssignment.index', compact('assetAssignments', 'pageTitle'));
    }

    public function create()
    {
        if(!Gate::allows('asset-assignment-create')){
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $assets = Asset::all();
//            $roles = Role::all();
            $locations = Location::all();
            $users = User::all();
        }
        else{
            $assets = Asset::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
//            $roles = Role::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
            $locations = Location::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
            $users = User::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.assetAssignment.add', compact('assets', 'locations', 'users'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'asset_id' => 'required',
                'assign_quantity' => 'required',
                'check_out_to' => 'required',
                'due_date' => 'required',
                'check_out_date' => 'required',
                'status' => 'required',
            ]);
            $assetAssignment = new AssetAssignment();
            $assetAssignment->asset_id = $request->asset_id;
            $assetAssignment->assign_quantity = $request->assign_quantity;
//            $assetAssignment->role_id = $request->role_id;
            $assetAssignment->check_out_to = $request->check_out_to;
            $assetAssignment->due_date = $request->due_date;
            $assetAssignment->check_out_date = $request->check_out_date;
            $assetAssignment->check_in_date = $request->check_in_date;
            $assetAssignment->location_id = $request->location_id;
            $assetAssignment->status = $request->status;
            $assetAssignment->note = $request->note;
            $assetAssignment->school_id = Auth::user()->school_id ?? Auth::id();
            $assetAssignment->created_by = Auth::id();
            $assetAssignment->save();
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        } catch(\Exception $e){
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if(!Gate::allows('asset-assignment-show')){
            return redirect()->route('unauthorized.action');
        }
        $assetAssignment = AssetAssignment::find($id);
        return view('admin.pages.assetAssignment.show', compact('assetAssignment'));
    }

    public function edit($id)
    {
        if(!Gate::allows('asset-assignment-edit')){
            return redirect()->route('unauthorized.action');
        }
        $editorId = (int) $id;
        $assetAssignment = AssetAssignment::find($id);
        if(auth()->user()->hasRole('Super Admin')){
            $assets = Asset::all();
//            $roles = Role::all();
            $locations = Location::all();
            $users = User::all();
        }
        else{
            $assets = Asset::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
//            $roles = Role::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
            $locations = Location::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
            $users = User::where('school_id', Auth::id())->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.assetAssignment.edit', compact('assetAssignment', 'assets', 'locations', 'users', 'editorId'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'asset_id' => 'required',
                'assign_quantity' => 'required',
                'check_out_to' => 'required',
                'due_date' => 'required',
                'check_out_date' => 'required',
                'status' => 'required',
            ]);
            $assetAssignment = AssetAssignment::find($id);
            $assetAssignment->asset_id = $request->asset_id;
            $assetAssignment->assign_quantity = $request->assign_quantity;
//            $assetAssignment->role_id = $request->role_id;
            $assetAssignment->check_out_to = $request->check_out_to;
            $assetAssignment->due_date = $request->due_date;
            $assetAssignment->check_out_date = $request->check_out_date;
            $assetAssignment->check_in_date = $request->check_in_date;
            $assetAssignment->location_id = $request->location_id;
            $assetAssignment->status = $request->status;
            $assetAssignment->note = $request->note;
            $assetAssignment->school_id = Auth::user()->school_id ?? Auth::id();
            $assetAssignment->updated_by = Auth::id();
            $assetAssignment->save();
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        } catch(\Exception $e){
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('asset-assignment-delete')){
            return redirect()->route('unauthorized.action');
        }
        $assetAssignment = AssetAssignment::find($id);
        $assetAssignment->delete();
        toastr()->success('Data has been deleted successfully!');
        return redirect()->back();
    }

    public function downloadPdf($id)
    {
        $assetAssignment = AssetAssignment::find($id);

        $pdf = PDF::loadView('admin.pages.assetAssignment.pdf', compact('assetAssignment'));

        return $pdf->download('asset_assignment_details.pdf');
    }
}
