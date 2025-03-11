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
            $examSchedules->where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id);
        }

        $examSchedules = $examSchedules->get();
        return view('admin.pages.examSchedule.index', compact('pageTitle', 'examSchedules', 'classes'));
    }

    public function create()
    {
        $pageTitle = 'Add Exam Schedule';
        $classes = ClassName::all();
        $exam = Exam::all();
        $subjects = Subject::all();
        $sections = SectionName::all();
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
            $examSchedule->date = $request->date;
            $examSchedule->time_from = $request->time_from;
            $examSchedule->time_to = $request->time_to;
            $examSchedule->room_no = $request->room_no;
            $examSchedule->school_id = Auth::id() ?? Auth::user()->school_id;
            $examSchedule->created_by = Auth::user()->id;
            $examSchedule->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->route('assignment.index')->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Exam Schedule';
        $classes = ClassName::all();
        $exam = Exam::all();
        $subjects = Subject::all();
        $sections = SectionName::all();
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
            $examSchedule->date = $request->date;
            $examSchedule->time_from = $request->time_from;
            $examSchedule->time_to = $request->time_to;
            $examSchedule->room_no = $request->room_no;
            $examSchedule->school_id = Auth::id() ?? Auth::user()->school_id;
            $examSchedule->updated_by = Auth::user()->id;
            $examSchedule->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->route('assignment.index')->with('error', 'Something went wrong');
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
            return redirect()->route('exam-schedule.index')->with('error', 'Something went wrong');
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
