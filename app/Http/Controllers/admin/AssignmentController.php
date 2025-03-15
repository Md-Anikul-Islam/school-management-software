<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\ClassName;
use App\Models\SectionName;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('assignment-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Assignments List';
        $classes = ClassName::all();

        $assignments = Assignment::with(['class', 'section', 'subject']);

        if ($request->class_id !== null && $request->class_id !== '') {
            $assignments->where('class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $assignments->where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id());
        }

        $assignments = $assignments->get();

        $assignments->each(function ($assignment) {
            $sectionIds = json_decode($assignment->section_id, true);

            if ($sectionIds && is_array($sectionIds)) {
                $sectionNames = SectionName::whereIn('id', $sectionIds)->pluck('name')->toArray();
                $assignment->sectionNames = !empty($sectionNames) ? json_encode($sectionNames) : null; //Store json encoded data.
            } else {
                $assignment->sectionNames = null;
            }
        });

        return view('admin.pages.assignment.index', compact('assignments', 'pageTitle', 'classes'));
    }

    public function create()
    {
        if (!Gate::allows('assignment-create')) {
            return redirect()->route('unauthorized.action');
        }
        $classes = ClassName::all();
        if (auth()->user()->hasRole('super-admin')) {
            $subjects = Subject::all();
        } else {

            $subjects = Subject::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }

        return view('admin.pages.assignment.add', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'deadline' => 'required',
                'class_id' => 'required',
                'section_id' => 'required|array', // Ensure section_id is an array
                'subject_id' => 'required',
                'file' => 'required',
            ]);

            $assignment = new Assignment();
            $assignment->title = $request->title;
            $assignment->description = $request->description;
            $assignment->deadline = $request->deadline;
            $assignment->class_id = $request->class_id;
            $assignment->section_id = json_encode($request->section_id); // Convert array to JSON
            $assignment->subject_id = $request->subject_id;
            $assignment->created_by = Auth::id();
            $assignment->school_id = Auth::user()->school_id ?? Auth::id();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/assignment/'), $fileName);
                $assignment->file = $fileName;
            }

            $assignment->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('assignment-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $assignment = Assignment::find($id);
        $classes = ClassName::all();
        $assignment->section_id = json_decode($assignment->section_id); // Decode JSON to array
        return view('admin.pages.assignment.edit', compact('assignment', 'classes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'deadline' => 'required',
                'class_id' => 'required',
                'section_id' => 'required|array', // Ensure section_id is an array
                'subject_id' => 'required',
            ]);

            $assignment = Assignment::find($id);
            $assignment->title = $request->title;
            $assignment->description = $request->description;
            $assignment->deadline = $request->deadline;
            $assignment->class_id = $request->class_id;
            $assignment->section_id = json_encode($request->section_id); // Convert array to JSON
            $assignment->subject_id = $request->subject_id;
            $assignment->updated_by = Auth::id();
            $assignment->school_id = Auth::user()->school_id ?? Auth::id();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/assignment/'), $fileName);
                $assignment->file = $fileName;
            }

            $assignment->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $assignment = Assignment::find($id);
            $assignment->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function fetchSections(Request $request)
    {
        $classId = $request->query('class_id');
        $sections = SectionName::where('class_id', $classId)->get();
        return response()->json($sections);
    }

    public function fetchSubjects(Request $request)
    {
        $classId = $request->query('class_id');
        $subjects = Subject::where('class_id', $classId)->get();
        return response()->json($subjects);
    }
}
