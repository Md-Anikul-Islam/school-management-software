<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Models\Event;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('event-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Event List';
        if (auth()->user()->role == 'Super Admin') {
            $events = Event::all();
        } else {
            $events = Event::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.event.index', compact('pageTitle', 'events'));
    }

    public function create()
    {
        return view('admin.pages.event.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'photo' => 'required',
                'details' => 'required',
            ]);
            $event = new Event();
            $event->title = $request->title;
            $event->from_date = $request->from_date;
            $event->to_date = $request->to_date;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/events/', $fileName);
            }
            $event->photo = $fileName;
            $event->details = $request->details;
            $event->school_id = Auth::user()->school_id ?? Auth::id();
            $event->created_by = Auth::id();
            $event->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Data cannot be saved!');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $event = Event::find($id);
        return view('admin.pages.event.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::find($id);
        $editorId = (int) $id;
        return view('admin.pages.event.edit', compact('event', 'editorId'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'photo' => 'required',
                'details' => 'required',
            ]);
            $event = Event::find($id);
            $event->title = $request->title;
            $event->from_date = $request->from_date;
            $event->to_date = $request->to_date;
            $fileName = $request->photo ?? "";
            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/events/' . $event->photo))) {
                    File::delete(public_path('uploads/events/' . $event->photo));
                }
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/events/'), $fileName);
            }
            $event->photo = $fileName;
            $event->details = $request->details;
            $event->school_id = Auth::user()->school_id ?? Auth::id();
            $event->updated_by = Auth::id();
            $event->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Data cannot be updated!');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::find($id);
            $event->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Data cannot be deleted!');
            return redirect()->back();
        }
    }

    public function pdf($id)
    {
        $event = Event::find($id);
        $createdBy = User::find($event->created_by); // Assuming 'created_by' stores the user ID
        $pdf = PDF::loadView('admin.pages.event.pdf', compact('event', 'createdBy'));
        return $pdf->download('event_' . $event->id . '.pdf');
    }
}
