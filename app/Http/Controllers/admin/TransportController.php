<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Transport;
use Illuminate\Support\Facades\Auth;

class TransportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('transport-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Transport List';
        if (auth()->user()->hasRole('Super Admin')){
            $transports = Transport::all();
        } else {
            $transports = Transport::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.transport.index', compact('transports', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('transport-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.transport.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'route_name' => 'required',
                'vehicle_no' => 'required',
                'route_fare' => 'required',
            ]);
            $transport = new Transport();
            $transport->route_name = $request->route_name;
            $transport->vehicle_no = $request->vehicle_no;
            $transport->route_fare = $request->route_fare;
            $transport->note = $request->note;
            $transport->school_id = Auth::user()->school_id ?? Auth::id();
            $transport->created_by = Auth::id();
            $transport->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('transport-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $transport = Transport::find($id);
        return view('admin.pages.transport.edit', compact('transport'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'route_name' => 'required',
                'vehicle_no' => 'required',
                'route_fare' => 'required',
            ]);
            $transport = Transport::find($id);
            $transport->route_name = $request->route_name;
            $transport->vehicle_no = $request->vehicle_no;
            $transport->route_fare = $request->route_fare;
            $transport->note = $request->note;
            $transport->school_id = Auth::user()->school_id ?? Auth::id();
            $transport->updated_by = Auth::id();
            $transport->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('transport-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $transport = Transport::find($id);
            $transport->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if (!Gate::allows('transport-show')) {
            return redirect()->route('unauthorized.action');
        }
        $transport = Transport::find($id);
        return view('admin.pages.transport.show', compact('transport'));
    }

    public function pdf($id)
    {
        $transport = Notice::find($id);
        $pdf = PDF::loadView('admin.pages.transport.pdf', compact('transport'));
        return $pdf->download('transport_' . $transport->id . '.pdf');
    }
}
