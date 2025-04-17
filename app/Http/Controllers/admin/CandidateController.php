<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('candidate-list',)) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Candidate List';
        if (auth()->user()->hasRole('Super Admin')){
            $candidates = Candidate::all();
        } else {
            $candidates = Candidate::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.candidate.index', compact('pageTitle', 'candidates'));
    }

    public function create()
    {
        if (!Gate::allows('candidate-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $students = Student::all();
        } else{
            $students = Student::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        $pageTitle = 'Add Candidate';
        return view('admin.pages.candidate.add', compact('students','pageTitle'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'student_id' => 'required|integer',
                'student_registration_number' => 'required|string|max:255',
                'class_id' => 'required|integer',
                'section_id' => 'required|integer',
                'application_verified_by' => 'required|string|max:255',
                'date_of_verification' => 'required|date',
            ]);

            $candidate = new Candidate();
            $candidate->student_id = $request->student_id;
            $candidate->student_registration_number = $request->student_registration_number;
            $candidate->class_id = $request->class_id;
            $candidate->section_id = $request->section_id;
            $candidate->application_verified_by = $request->application_verified_by;
            $candidate->date_of_verification = $request->date_of_verification;
            $candidate->school_id = Auth::user()->school_id ?? Auth::id();
            $candidate->created_by = Auth::id();
            $candidate->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('candidate-edit')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $students = Student::all();
        } else{
            $students = Student::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        $candidate = Candidate::find($id);
        return view('admin.pages.candidate.edit', compact('candidate', 'students'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'student_id' => 'required|integer',
                'student_registration_number' => 'required|string|max:255',
                'class_id' => 'required|integer',
                'section_id' => 'required|integer',
                'application_verified_by' => 'required|string|max:255',
                'date_of_verification' => 'required|date',
            ]);

            $candidate = Candidate::find($id);
            $candidate->student_id = $request->student_id;
            $candidate->student_registration_number = $request->student_registration_number;
            $candidate->class_id = $request->class_id;
            $candidate->section_id = $request->section_id;
            $candidate->application_verified_by = $request->application_verified_by;
            $candidate->date_of_verification = $request->date_of_verification;
            $candidate->school_id = Auth::user()->school_id ?? Auth::id();
            $candidate->updated_by = Auth::id();
            $candidate->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('candidate-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $candidate = Candidate::find($id);
            $candidate->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if (!Gate::allows('candidate-show')) {
            return redirect()->route('unauthorized.action');
        }
        $candidate = Candidate::find($id);
        return view('admin.pages.candidate.show', compact('candidate'));
    }

    public function pdf($id)
    {
        $candidate = Candidate::findOrFail($id); // Find the candidate
        $pdf = PDF::loadView('admin.pages.candidate.pdf', compact('candidate')); // Load the PDF view
        return $pdf->download('candidate_details.pdf'); // Download the PDF
    }

    public function getStudentData($studentId)
    {
        $student = Student::find($studentId);
        if ($student) {
            return response()->json(['reg_no' => $student->reg_no, 'class_id' => $student->class_id, 'section_id' => $student->section_id]);
        } else {
            return response()->json(['code' => '', 'fee' => '']);
        }
    }
}
