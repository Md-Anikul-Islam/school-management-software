<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SponsorshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('sponsorship-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Sponsorship List';
        if (auth()->user()->hasRole('Super Admin')) {
            $sponsorships = Sponsorship::all();
        } else {
            $sponsorships = Sponsorship::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.sponsorship.index', compact('sponsorships', 'pageTitle'));
    }

    public function create()
    {
        if(!Gate::allows('sponsorship-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $candidates = Candidate::all();
            $sponsors = Sponsor::all();
        } else {
            $candidates = Candidate::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $sponsors = Sponsor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.sponsorship.add', compact('candidates', 'sponsors'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'candidate_id' => 'required',
                'sponsor_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'amount' => 'required|numeric',
                'payment_date' => 'required|date',
            ]);

            $sponsorship = new Sponsorship();
            $sponsorship->candidate_id = $request->candidate_id;
            $sponsorship->sponsor_id = $request->sponsor_id;
            $sponsorship->start_date = $request->start_date;
            $sponsorship->end_date = $request->end_date;
            $sponsorship->amount = $request->amount;
            $sponsorship->payment_date = $request->payment_date;
            $sponsorship->school_id = Auth::user()->school_id ?? Auth::id();
            $sponsorship->created_by = Auth::id();
            $sponsorship->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('sponsorship-edit')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $candidates = Candidate::all();
            $sponsors = Sponsor::all();
        } else {
            $candidates = Candidate::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $sponsors = Sponsor::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        $sponsorship = Sponsorship::findOrFail($id);
        return view('admin.pages.sponsorship.edit', compact('sponsorship', 'candidates', 'sponsors'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'candidate_id' => 'required',
                'sponsor_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'amount' => 'required|numeric',
                'payment_date' => 'required|date',
            ]);

            $sponsorship = Sponsorship::findOrFail($id);
            $sponsorship->candidate_id = $request->candidate_id;
            $sponsorship->sponsor_id = $request->sponsor_id;
            $sponsorship->start_date = $request->start_date;
            $sponsorship->end_date = $request->end_date;
            $sponsorship->amount = $request->amount;
            $sponsorship->payment_date = $request->payment_date;
            $sponsorship->school_id = Auth::user()->school_id ?? Auth::id();
            $sponsorship->updated_by = Auth::id();
            $sponsorship->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('sponsorship-delete')) {
            return redirect()->route('unauthorized.action');
        }
        $sponsorship = Sponsorship::findOrFail($id);
        $sponsorship->delete();
        toastr()->success('Data has been deleted successfully!');
        return redirect()->back();
    }

    public function renew($id)
    {
        if (!Gate::allows('sponsorship-renew')) {
            return redirect()->route('unauthorized.action');
        }
        $sponsorship = Sponsorship::findOrFail($id); // Find the sponsorship by ID.
        return view('admin.pages.sponsorship.renew', compact('sponsorship'));
    }

    public function renew_sponsorship(Request $request, $id) // Corrected function definition
    {
        try {
            $request->validate([
                'payment_date' => 'required|date',
            ]);

            $sponsorship = Sponsorship::findOrFail($id); // Find sponsorship by ID
            $sponsorship->payment_date = $request->payment_date;
            $sponsorship->save();
            toastr()->success('Sponsorship has been renewed successfully!');
            return redirect()->route('sponsorship.index'); // Redirect to the index page
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
