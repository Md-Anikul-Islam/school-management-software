<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        if (auth()->user()->hasRole('Super Admin')) {
            $students = Student::latest()->paginate(10);
        } else {
            $students = Student::where('school_id', Auth::id())->get();
        }
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
                'name' => 'required',
                'class_id' => 'required',
                'section_id' => 'required',
                'reg_no' => 'required',
                'roll' => 'required',
            ]);

            $filename = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/students/'), $filename);
            }

            $student = new Student();
            $student->name = $request->name;
            $student->guardian_id = $request->guardian_id;
            $student->admission_date = $request->admission_date;
            $student->dob = $request->dob;
            $student->gender = $request->gender;
            $student->blood_group_id = $request->blood_group_id;
            $student->religion = $request->religion;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->city = $request->city;
            $student->country_id = $request->country_id;
            $student->class_id = $request->class_id;
            $student->section_id = $request->section_id;
            $student->group_id = $request->group_id;
            $student->optional_subject_id = $request->optional_subject_id;
            $student->reg_no = $request->reg_no;
            $student->roll = $request->roll;
            $student->photo = $filename;
            $student->extra_curricular_activities = $request->extra_curricular_activities;
            $student->remarks = $request->remarks;
            $student->username = $request->username;
            $student->password = $request->password;
            $student->status = $request->status ?? 1;
            $student->school_id = Auth::id() ?? Auth::user()->school_id;
            $student->created_by = Auth::id();
            $student->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::find($id);
        return view('admin.pages.student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::find($id);
        return view('admin.pages.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'class_id' => 'required',
                'section_id' => 'required',
                'reg_no' => 'required',
                'roll' => 'required',
            ]);

            $student = Student::find($id);

            $filename = $student->photo ?? "";
            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/students/' . $student->photo))) {
                    File::delete(public_path('uploads/students/' . $student->photo));
                }
                $file = $request->file('photo');
                $filename = date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/students/'), $filename);
            }

            $student->name = $request->name;
            $student->guardian_id = $request->guardian_id;
            $student->admission_date = $request->admission_date;
            $student->dob = $request->dob;
            $student->gender = $request->gender;
            $student->blood_group_id = $request->blood_group_id;
            $student->religion = $request->religion;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->city = $request->city;
            $student->country_id = $request->country_id;
            $student->class_id = $request->class_id;
            $student->section_id = $request->section_id;
            $student->group_id = $request->group_id;
            $student->optional_subject_id = $request->optional_subject_id;
            $student->reg_no = $request->reg_no;
            $student->roll = $request->roll;
            $student->photo = $filename;
            $student->extra_curricular_activities = $request->extra_curricular_activities;
            $student->remarks = $request->remarks;
            $student->username = $request->username;
            $student->password = $request->password;
            $student->status = $request->status ?? $student->status;
            $student->updated_by = Auth::id();
            $student->save();

            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong! Please try again');
            return redirect()->back();
        }
    }

    /**
     * Update the status of the specified resource.
     */
    public function update_status(Request $request, $id)
    {
        try {
            $student = Student::find($id);
            $student->status = $request->has('status') ? 1 : 0;
            $student->updated_by = Auth::id();
            $student->save();
            toastr()->success('Status has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong! Please try again');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = Student::find($id);
            $student->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }
}
