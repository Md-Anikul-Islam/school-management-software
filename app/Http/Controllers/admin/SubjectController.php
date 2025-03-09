<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('subject-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Subject List';
        if(auth()->user()->hasRole('Super Admin')){
            $subjects = Subject::latest()->get();
        } else {
            $subjects = Subject::where('school_id', Auth::id())->get();
        }
        return view('admin.pages.subject.index', compact('pageTitle', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $classes = ClassName::latest()->get();
            $teachers = Teacher::latest()->get();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->latest()->get();
            $teachers = Teacher::where('school_id', Auth::id())->latest()->get();
        }
        return view('admin.pages.subject.add', compact('classes', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'class_id' => 'required',
                'teacher_id' => 'required',
                'type' => 'required',
                'pass_mark' => 'required',
                'final_mark' => 'required',
                'name' => 'required',
                'subject_author' => 'required',
                'subject_code' => 'required',
                'status' => 'required',
            ]);
            $subject = new Subject();
            $subject->class_id = $request->class_id;
            $subject->teacher_id = $request->teacher_id;
            $subject->type = $request->type ?? 'Mandatory';
            $subject->pass_mark = $request->pass_mark;
            $subject->final_mark = $request->final_mark;
            $subject->name = $request->name;
            $subject->subject_author = $request->subject_author;
            $subject->subject_code = $request->subject_code;
            $subject->school_id = Auth::id() ?? Auth::user()->school_id;
            $subject->created_by = Auth::id();
            $subject->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::find($id);
        return view('admin.pages.subject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        if(auth()->user()->hasRole('Super Admin')){
            $classes = ClassName::latest()->get();
            $teachers = Teacher::latest()->get();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->latest()->get();
            $teachers = Teacher::where('school_id', Auth::id())->latest()->get();
        }
        return view('admin.pages.subject.edit', compact('subject', 'classes', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'class_id' => 'required',
                'teacher_id' => 'required',
                'type' => 'required',
                'pass_mark' => 'required',
                'final_mark' => 'required',
                'name' => 'required',
                'subject_author' => 'required',
                'subject_code' => 'required',
                'status' => 'required',
            ]);
            $subject = Subject::find($id);
            $subject->class_id = $request->class_id;
            $subject->teacher_id = $request->teacher_id;
            $subject->type = $request->type ?? 'Mandatory';
            $subject->pass_mark = $request->pass_mark;
            $subject->final_mark = $request->final_mark;
            $subject->name = $request->name;
            $subject->subject_author = $request->subject_author;
            $subject->subject_code = $request->subject_code;
            $subject->status = $request->status;
            $subject->school_id = Auth::id() ?? Auth::user()->school_id;
            $subject->updated_by = Auth::id();
            $subject->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subject = Subject::find($id);
            $subject->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }
}
