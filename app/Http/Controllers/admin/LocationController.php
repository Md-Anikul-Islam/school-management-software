<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use Illuminate\Support\Facades\Gate;


class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('location-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Location';
        if(auth()->user()->hasRole('Super Admin')){
            $locations = Location::all();
        } else {
            $locations = Location::where('school_id', Auth()->user()->school_id)->orWhere('school_id', Auth::id()->school_id)->get();
        }
        return view('admin.pages.location.index', compact('locations', 'pageTitle'));
    }

    public function create()
    {
        if(!Gate::allows('location-create')){
            return redirect()->route('unauthorized.action');
        }
        $pageTitle = 'Add Location';
        return view('admin.pages.location.add', compact('pageTitle'));
    }

    public function store(Request $request){
        try{
            $request->validate([
                'location' => 'required',
                'description' => 'required',
            ]);
            $location = new Location();
            $location->location = $request->location;
            $location->description = $request->description;
            $location->school_id = Auth()->user()->school_id ?? Auth()->id();
            $location->created_by = Auth()->id();
            $location->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('location-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $location = Location::find($id);
        $key = (int)$id;
        return view('admin.pages.location.edit', compact('location', 'key'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'location' => 'required',
                'description' => 'required',
            ]);
            $location = Location::find($id);
            $location->location = $request->location;
            $location->description = $request->description;
            $location->school_id = Auth()->user()->school_id ?? Auth()->id();
            $location->updated_by = Auth()->id();
            $location->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('location-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $location = Location::find($id);
            $location->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

}
