<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Mark;
use App\Models\SectionName;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('mark-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Marks List';
        $marks = Mark::selectRaw('
                MIN(id) as id, class_id, exam_id, section_id, subject_id,
                MIN(created_at) as created_at, MIN(updated_at) as updated_at
            ')
            ->whereNull('deleted_at')
            ->groupBy('class_id', 'exam_id', 'section_id', 'subject_id')
            ->get();

        return view('admin.pages.mark.index', compact('pageTitle', 'marks'));
    }

    public function create()
    {
        $classes = ClassName::all();
        $exams = Exam::all();
        $sections = SectionName::all();

        // Get subjects based on exam schedules
        $examSchedules = ExamSchedule::with(['subject', 'exam'])->get();

        return view('admin.pages.mark.add', compact('classes', 'exams', 'sections', 'examSchedules'));
    }

    public function store(Request $request)
    {
        try{
            // Validate required fields
            $request->validate([
                'class' => 'required|integer',
                'exam' => 'required|integer',
                'section' => 'required|integer',
                'subject' => 'required|integer',
                'student_id' => 'required|array',
                'exam.*' => 'required|integer',
                'attendance.*' => 'nullable|integer',
                'class_test.*' => 'nullable|integer',
                'assignment.*' => 'nullable|integer',
            ]);

            // Loop through each student and store marks
            foreach ($request->student_id as $student_id) {
                Mark::create([
                    'class_id' => $request->class,
                    'exam_id' => $request->exam,
                    'section_id' => $request->section,
                    'subject_id' => $request->subject,
                    'student_id' => $student_id,
                    'exam_mark' => $request->exam_mark[$student_id],
                    'attendance' => $request->attendance[$student_id] ?? null,
                    'class_test' => $request->class_test[$student_id] ?? null,
                    'assignment' => $request->assignment[$student_id] ?? null,
                    'created_by' => Auth::id(),
                ]);
            }

            // Check if the request is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'success', 'message' => 'Data has been saved successfully!']);
            } else {
                toastr()->success('Data has been saved successfully!');
                return redirect()->back();
            }

        } catch (\Exception $e){
            // Check if the request is an AJAX request for error response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again']);
            } else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again');
            }
        }
    }

    public function edit($id)
    {
        // Fetch the primary mark using the given ID
        $mark = Mark::findOrFail($id);

        // Fetch all related marks for the same class, exam, section, and subject
        $marks = Mark::with('student')
            ->where('class_id', $mark->class_id)
            ->where('exam_id', $mark->exam_id)
            ->where('section_id', $mark->section_id)
            ->where('subject_id', $mark->subject_id)
            ->whereNull('deleted_at')
            ->get();

        // Fetch additional data for the edit view
        $classes = ClassName::all();
        $exams = Exam::all();
        $sections = SectionName::all();
        $examSchedules = ExamSchedule::with(['subject', 'exam'])->get();

        return view('admin.pages.mark.edit', compact('mark', 'marks', 'classes', 'exams', 'sections', 'examSchedules'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Get all student IDs from the request
            $studentIds = $request->student_id;

            if (!$studentIds) {
                return redirect()->back()->with('error', 'No marks found to update.');
            }

            // Loop through each mark and update it
            foreach ($studentIds as $studentId) {
                $mark = Mark::where('student_id', $studentId)
                    ->where('class_id', $request->class)
                    ->where('exam_id', $request->exam)
                    ->where('section_id', $request->section)
                    ->where('subject_id', $request->subject)
                    ->first();

                $mark->exam_mark = $request->input("exam_mark.$studentId");
                $mark->attendance = $request->input("attendance.$studentId");
                $mark->class_test = $request->input("class_test.$studentId");
                $mark->assignment = $request->input("assignment.$studentId");
                $mark->updated_by = auth()->id();
                $mark->save();
            }
            // Check if the request is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'success', 'message' => 'Data has been updated successfully!']);
            } else {
                toastr()->success('Data has been updated successfully!');
                return redirect()->back();
            }
        } catch (\Exception $e){
            // Check if the request is an AJAX request for error response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again']);
            } else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again');
            }
        }
    }

    public function destroy($id)
    {
        try{
            $mark = Mark::find($id);
            $mark->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function getExamStudents(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'exam_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required'
        ]);

        // Fetch students of that class and section
        $students = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get();

        if ($students->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No students found.']);
        }

        // Fetch full Exam and Subject entities
        $exam = Exam::find($request->exam_id);
        $subject = Subject::find($request->subject_id);

        return response()->json([
            'status' => 'success',
            'students' => $students,
            'exam' => $exam,   // Send full Exam object
            'subject' => $subject // Send full Subject object
        ]);
    }
}
