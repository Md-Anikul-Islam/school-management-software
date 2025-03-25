<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('holiday-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = "Holiday List";
        if(auth()->user()->hasRole('Super Admin')) {
            $holidays = Holiday::all();
        } else {
            $holidays = Holiday::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.holiday.index', compact('pageTitle', 'holidays'));
    }

    public function create()
    {
        if(!Gate::allows('holiday-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.holiday.add');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'title' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'photo' => 'required',
                'details' => 'required',
            ]);

            $holiday = new Holiday();
            $holiday->title = $request->title;
            $holiday->from_date = $request->from_date;
            $holiday->to_date = $request->to_date;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/holidays/', $fileName);
            }
            $holiday->photo = $fileName;
            $holiday->details = $request->details;
            $holiday->school_id = Auth::user()->school_id ?? Auth::id();
            $holiday->created_by = Auth::id();
            $holiday->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if(!Gate::allows('holiday-show')) {
            return redirect()->route('unauthorized.action');
        }
        $holiday = Holiday::find($id);
        return view('admin.pages.holiday.show', compact('holiday'));
    }

    public function edit($id)
    {
        if(!Gate::allows('holiday-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $editorId = (int) $id;
        $holiday = Holiday::find($id);
        return view('admin.pages.holiday.edit', compact('holiday', 'editorId'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'title' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'photo' => 'required',
                'details' => 'required',
            ]);

            $holiday = Holiday::find($id);
            $holiday->title = $request->title;
            $holiday->from_date = $request->from_date;
            $holiday->to_date = $request->to_date;
            $fileName = $request->photo ?? "";
            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/holidays/' . $holiday->photo))) {
                    File::delete(public_path('uploads/holidays/' . $holiday->photo));
                }
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/holidays/'), $fileName);
            }
            $holiday->photo = $fileName;
            $holiday->details = $request->details;
            $holiday->school_id = Auth::user()->school_id ?? Auth::id();
            $holiday->updated_by = Auth::id();
            $holiday->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('holiday-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $holiday = Holiday::find($id);
            if (File::exists(public_path('uploads/holidays/' . $holiday->photo))) {
                File::delete(public_path('uploads/holidays/' . $holiday->photo));
            }
            $holiday->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function pdf($id)
    {
        $holiday = Holiday::find($id);
        $pdf = PDF::loadView('admin.pages.holiday.pdf', compact('holiday'));
        return $pdf->download('holiday_' . $holiday->id . '.pdf');
    }
}
