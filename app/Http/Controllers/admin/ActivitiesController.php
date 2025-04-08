<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ActivitiesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Activities;

class ActivitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('activities-list',)) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if(auth()->user()->can('Super Admin')) {
            $activityCategories = ActivitiesCategory::all();
            $activities = Activities::all();
        } else{
            $activityCategories = ActivitiesCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $activities = Activities::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.activities.index', compact('activities', 'activityCategories'));
    }

    public function create()
    {
        if (!Gate::allows('activities-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->can('Super Admin')) {
            $activityCategories = ActivitiesCategory::all();
        } else {
            $activityCategories = ActivitiesCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.activities.add', compact('activityCategories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'description' => 'required',
                'time_frame_start' => 'required',
                'time_frame_end' => 'required|after_or_equal:time_frame_start',
            ]);

            $activity = new Activities();
            $activity->activity_category_id = $request->activity_category_id;
            $activity->description = $request->description;
            $activity->time_frame_start = $request->time_frame_start;
            $activity->time_frame_end = $request->time_frame_end;
            $activity->time_at = $request->time_at;
            $activity->school_id = Auth::user()->school_id ?? Auth::id();
            $activity->created_by = Auth::id();

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/attachments/'), $filename);
                $activity->attachment = $filename;
            }

            $activity->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('activities-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $activity = Activities::findOrFail($id);
            $activity->delete();
            if ($activity->attachment) {
                $filePath = public_path($activity->attachment);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('An error occurred while deleting the data.');
            return redirect()->back();
        }
    }
}
