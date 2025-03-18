<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HostelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('hostel-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Hostel List';
        if(auth()->user()->hasRole('Super Admin')) {
            $hostels = Hostel::all();
        } else {
            $hostels = Hostel::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.hostel.index', compact('hostels', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('hostel-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.hostel.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'type' => 'required',
                'address' => 'required',
            ]);

            $hostel = new Hostel();
            $hostel->name = $request->name;
            $hostel->type = $request->type;
            $hostel->address = $request->address;
            $hostel->note = $request->note;
            $hostel->school_id = Auth::user()->school_id ?? Auth::id();
            $hostel->created_by = Auth::id();
            $hostel->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('hostel-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $hostel = Hostel::find($id);
        return view('admin.pages.hostel.edit', compact('hostel'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'type' => 'required',
                'address' => 'required',
            ]);

            $hostel = Hostel::find($id);
            $hostel->name = $request->name;
            $hostel->type = $request->type;
            $hostel->address = $request->address;
            $hostel->note = $request->note;
            $hostel->school_id = Auth::user()->school_id ?? Auth::id();
            $hostel->updated_by = Auth::id();
            $hostel->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('hostel-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $hostel = Hostel::find($id);
            $hostel->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
