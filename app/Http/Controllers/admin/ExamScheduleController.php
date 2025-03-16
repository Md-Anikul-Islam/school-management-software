<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\SectionName;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class ExamScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('exam-schedule-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Exam Schedule List';
        $classes = ClassName::all();

        $examSchedules = ExamSchedule::with(['class', 'section', 'subject', 'exam']);

        if ($request->class_id !== null && $request->class_id !== '') {
            $examSchedules->where('class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $examSchedules->where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id());
        }

        $examSchedules = $examSchedules->get();
        return view('admin.pages.examSchedule.index', compact('pageTitle', 'examSchedules', 'classes'));
    }

    public function create()
    {
        if (!Gate::allows('exam-schedule-create')) {
            return redirect()->route('unauthorized.action');
        }
        $pageTitle = 'Add Exam Schedule';
        $classes = ClassName::all();
        if(auth()->user()->hasRole('Super Admin')) {
            $exam = Exam::all();
            $subjects = Subject::all();
            $sections = SectionName::all();
        } else {
            $exam = Exam::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $subjects = Subject::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $sections = SectionName::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.examSchedule.add', compact('pageTitle', 'classes', 'exam', 'subjects', 'sections'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'class_id' => 'required',
                'exam_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required',
                'date' => 'required',
                'time_from' => 'required',
                'time_to' => 'required',
                'room_no' => 'required',
            ]);

            $examSchedule = new ExamSchedule();
            $examSchedule->class_id = $request->class_id;
            $examSchedule->exam_id = $request->exam_id;
            $examSchedule->section_id = $request->section_id;
            $examSchedule->subject_id = $request->subject_id;
            $examSchedule->date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');;
            $examSchedule->time_from = $request->time_from;
            $examSchedule->time_to = $request->time_to;
            $examSchedule->room_no = $request->room_no;
            $examSchedule->school_id = Auth::user()->school_id ?? Auth::id();
            $examSchedule->created_by = Auth::user()->id;
            $examSchedule->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('exam-schedule-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $pageTitle = 'Edit Exam Schedule';
        $classes = ClassName::all();
        if(auth()->user()->hasRole('Super Admin')) {
            $exam = Exam::all();
            $subjects = Subject::all();
            $sections = SectionName::all();
        } else {
            $exam = Exam::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $subjects = Subject::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $sections = SectionName::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        $examSchedule = ExamSchedule::find($id);
        return view('admin.pages.examSchedule.edit', compact('pageTitle', 'classes', 'exam', 'subjects', 'sections', 'examSchedule'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'class_id' => 'required',
                'exam_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required',
                'date' => 'required',
                'time_from' => 'required',
                'time_to' => 'required',
                'room_no' => 'required',
            ]);

            $examSchedule = ExamSchedule::find($id);
            $examSchedule->class_id = $request->class_id;
            $examSchedule->exam_id = $request->exam_id;
            $examSchedule->section_id = $request->section_id;
            $examSchedule->subject_id = $request->subject_id;
            $examSchedule->date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');;
            $examSchedule->time_from = $request->time_from;
            $examSchedule->time_to = $request->time_to;
            $examSchedule->room_no = $request->room_no;
            $examSchedule->school_id = Auth::user()->school_id ?? Auth::id();
            $examSchedule->updated_by = Auth::user()->id;
            $examSchedule->save();
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
            $examSchedule = ExamSchedule::find($id);
            $examSchedule->delete();
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
