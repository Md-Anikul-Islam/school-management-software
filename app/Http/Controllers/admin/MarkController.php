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
        $marks = Mark::all();
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

//    public function store(Request $request)
//    {
//        try{
//            // Validate required fields
//            $request->validate([
//                'class' => 'required|integer',
//                'exam' => 'required|integer',
//                'section' => 'required|integer',
//                'subject' => 'required|integer',
//                'student_id' => 'required|array',
//                'exam.*' => 'required|integer',
//                'attendance.*' => 'nullable|integer',
//                'class_test.*' => 'nullable|integer',
//                'assignment.*' => 'nullable|integer',
//            ]);
//
//            // Loop through each student and store marks
//            foreach ($request->student_id as $student_id) {
//                Mark::create([
//                    'class_id' => $request->class,
//                    'exam_id' => $request->exam,
//                    'section_id' => $request->section,
//                    'subject_id' => $request->subject,
//                    'student_id' => $student_id,
//                    'exam_mark' => $request->exam_mark[$student_id],
//                    'attendance' => $request->attendance[$student_id] ?? null,
//                    'class_test' => $request->class_test[$student_id] ?? null,
//                    'assignment' => $request->assignment[$student_id] ?? null,
//                    'created_by' => Auth::id(),
//                ]);
//            }
//            toastr()->success('Data has been saved successfully!');
//            return redirect()->back();
//        } catch (\Exception $e){
//            toastr()->error($e->getMessage(), ['title' => 'Error']);  //when catch(\Exception $e)
//            return redirect()->back();
//        }
//    }

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
        $mark = Mark::find($id);
        return view('admin.pages.mark.edit', compact('mark'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required',
            ]);
            $mark = Mark::find($id);
            $mark->name = $request->name;
            $mark->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
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
