<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('sponsor-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Sponsor List';
        if (auth()->user()->hasRole('Super Admin')) {
            $sponsors = Sponsor::all();
        } else {
            $sponsors = Sponsor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }

        return view('admin.pages.sponsor.index', compact('pageTitle', 'sponsors'));
    }

    public function create()
    {
        if(!Gate::allows('sponsor-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.sponsor.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'name' => 'required',
                'organization_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'country' => 'required',
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $sponsor = new Sponsor();
            $sponsor->title = $request->title;
            $sponsor->name = $request->name;
            $sponsor->organization_name = $request->organization_name;
            $sponsor->email = $request->email;
            $sponsor->phone = $request->phone;
            $sponsor->address = $request->address;
            $sponsor->country = $request->country;

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/sponsors'), $filename);
                $sponsor->photo = $filename;
            }

            $sponsor->school_id = Auth::user()->school_id ?? Auth::id();
            $sponsor->created_by = Auth::id();
            $sponsor->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('sponsor-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $sponsor = Sponsor::find($id);
        return view('admin.pages.sponsor.edit', compact('sponsor'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'name' => 'required',
                'organization_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'country' => 'required',
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $sponsor = Sponsor::find($id);
            $sponsor->title = $request->title;
            $sponsor->name = $request->name;
            $sponsor->organization_name = $request->organization_name;
            $sponsor->email = $request->email;
            $sponsor->phone = $request->phone;
            $sponsor->address = $request->address;
            $sponsor->country = $request->country;

            if ($request->hasFile('photo')) {
                if ($sponsor->photo) {
                    unlink(public_path($sponsor->photo));
                }
                $file = $request->file('photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/sponsors'), $filename);
                $sponsor->photo = $filename;
            }

            $sponsor->school_id = Auth::user()->school_id ?? Auth::id();
            $sponsor->updated_by = Auth::id();
            $sponsor->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('sponsor-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $sponsor = Sponsor::find($id);
            if ($sponsor->photo) {
                unlink(public_path($sponsor->photo));
            }
            $sponsor->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if(!Gate::allows('sponsor-show')) {
            return redirect()->route('unauthorized.action');
        }
        $sponsor = Sponsor::find($id);
        return view('admin.pages.sponsor.show', compact('sponsor'));
    }

    public function pdf($id)
    {
        $sponsor = Sponsor::findOrFail($id); // Find the sponsor
        $pdf = PDF::loadView('admin.pages.sponsor.pdf', compact('sponsor')); // Load the PDF view
        return $pdf->download('sponsor_details.pdf'); // Download the PDF
    }
}
