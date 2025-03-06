<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('student-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Student List';
        $students = Student::latest()->paginate(10);
        return view('admin.pages.student.index', compact('pageTitle', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.student.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required',
                'name' => 'required',
                'roll' => 'required',
                'email' => 'required',
            ]);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/students/'), $filename);
            }

            $student = new Student();
            $student->photo = $filename;
            $student->name = $request->name;
            $student->roll = $request->roll;
            $student->email = $request->email;
            $student->school_id = Auth::id() ?? Auth::user()->school_id;
            $student->created_by = Auth::id();
            $student->save();
            Toastr::success('Data Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        return view('admin.pages.student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        return view('admin.pages.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'photo' => 'file|required',
                'name' => 'required',
                'roll' => 'required',
                'email' => 'required',
                'status' => 'required',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/students/'), $filename);
            }

            $student = Student::find($id);
            $student->photo = $filename;
            $student->name = $request->name;
            $student->roll = $request->roll;
            $student->email = $request->email;
            $student->status = $request->status;
            $student->updated_by = Auth::id();
            $student->save();
            return redirect()->route('student.edit', $id)->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $student = Student::find($id);
            $student->delete();
            return redirect()->route('student.index')->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
