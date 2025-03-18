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
    public function index(Request $request)
    {
        $pageTitle = 'Subject List';
        $classes = ClassName::all();

        $subjects = Subject::with('class');

        if ($request->class_id !== null && $request->class_id !== '') {
            $subjects->where('class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $subjects->where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id);
        }

        $subjects = $subjects->latest()->get();

        $subjects->each(function ($subject) {
            if ($subject->teacher_ids) {
                $teacherIds = json_decode($subject->teacher_ids, true);
                if ($teacherIds && is_array($teacherIds)) {
                    $teacherNames = Teacher::whereIn('id', $teacherIds)->pluck('name')->toArray();
                    $subject->teacherNames = !empty($teacherNames) ? json_encode($teacherNames) : null;
                } else {
                    $subject->teacherNames = null;
                }
            } else {
                $subject->teacherNames = null;
            }
        });

        return view('admin.pages.subject.index', compact('subjects', 'pageTitle', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('subject-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $classes = ClassName::latest()->get();
            $teachers = Teacher::latest()->get();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->latest()->get();
            $teachers = Teacher::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->latest()->get();
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
                'teacher_id' => 'required|array',
                'type' => 'required',
                'pass_mark' => 'required',
                'final_mark' => 'required',
                'name' => 'required',
                'subject_author' => 'required',
                'subject_code' => 'required',
            ]);
            $subject = new Subject();
            $subject->class_id = $request->class_id;
            $subject->type = $request->type ?? 'Mandatory';
            $subject->pass_mark = $request->pass_mark;
            $subject->final_mark = $request->final_mark;
            $subject->name = $request->name;
            $subject->subject_author = $request->subject_author;
            $subject->subject_code = $request->subject_code;
            $subject->school_id = Auth::user()->school_id ?? Auth::id();
            $subject->created_by = Auth::id();
            $subject->teacher_ids = json_encode($request->teacher_id);
            $subject->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Gate::allows('subject-show')) {
            return redirect()->route('unauthorized.action');
        }
        $subject = Subject::find($id);
        return view('admin.pages.subject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Gate::allows('subject-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $subject = Subject::find($id);
        if (auth()->user()->hasRole('Super Admin')) {
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
                'teacher_id' => 'required|array',
                'type' => 'required',
                'pass_mark' => 'required',
                'final_mark' => 'required',
                'name' => 'required',
                'subject_author' => 'required',
                'subject_code' => 'required',
            ]);
            $subject = Subject::find($id);
            $subject->class_id = $request->class_id;
            $subject->type = $request->type ?? 'Mandatory';
            $subject->pass_mark = $request->pass_mark;
            $subject->final_mark = $request->final_mark;
            $subject->name = $request->name;
            $subject->subject_author = $request->subject_author;
            $subject->subject_code = $request->subject_code;
            $subject->school_id = Auth::user()->school_id ?? Auth::id();
            $subject->updated_by = Auth::id();
            $subject->teacher_ids = json_encode($request->teacher_id);
            $subject->save();

            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Gate::allows('subject-delete')){
            return redirect()->route('unauthorized.action');
        }
        try {
            $subject = Subject::find($id);
            $subject->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
