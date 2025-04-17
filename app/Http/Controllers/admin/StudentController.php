<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\GroupName;
use App\Models\Guardian;
use App\Models\SectionName;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StudentController extends Controller
{
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
        try {
            $students = Student::all();
            return view('admin.pages.student.index', compact('students'));
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);  //when catch(\Exception $e)
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new student.
     */

    public function create()
    {
        if(!Gate::allows('student-create')){
            return redirect()->route('unauthorized.action');
        }
        try {
            $subjects = Subject::all();
            $classNames = ClassName::all();
            $sections = SectionName::all();
            $groups = GroupName::all();
            $guardians = Guardian::all();
            return view('admin.pages.student.add', compact('subjects', 'classNames', 'sections', 'groups', 'guardians'));
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'guardian_id' => 'required',
                'admission_date' => 'required|date',
                'dob' => 'required|date',
                'gender' => 'required|integer',
                'blood_group_id' => 'required|string',
                'religion' => 'required|string',
                'email' => 'nullable|email|unique:students,email',
                'phone' => 'nullable|string|unique:students,phone',
                'address' => 'required|string',
                'city' => 'required|string',
                'className' => 'required|integer',
                'section' => 'required|integer',
                'optional_subject_id' => 'nullable|integer',
                'reg_no' => 'nullable|string',
                'roll' => 'nullable|string',
                'photo' => 'nullable',
                'username' => 'nullable|string|unique:students,username',
                'password' => 'nullable|string|min:6',
            ]);

            // Handle File Upload


            // Create New Student
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
            $student->class_id = $request->className;
            $student->section_id = $request->section;
            $student->group = $request->group;
            $student->optional_subject_id = $request->optional_subject_id;
            $student->reg_no = $request->reg_no;
            $student->roll = $request->roll;
            $student->extra_curricular_activities = $request->extra_curricular_activities;
            $student->remarks = $request->remarks;
            $student->username = $request->username;
            $student->password = $request->password ? Hash::make($request->password) : null;
            $student->status = 1;
            $student->school_id = auth()->user()->school_id ?? null;
            $student->created_by = auth()->id();
            if ($request->photo) {
                $file = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('uploads/students'), $file);
                $student->photo = $file;
            }
            $student->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->route('student.index');
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }


    /**
     * Show the form for editing the specified student.
     */
    public function edit($id)
    {
        if(!Gate::allows('student-edit')){
            return redirect()->route('unauthorized.action');
        }
        try {
            $student = Student::findOrFail($id);
            $subjects = Subject::all();
            $classNames = ClassName::all();
            $sections = SectionName::all();
            $groups = GroupName::all();
            $guardians = Guardian::all();
            return view('admin.pages.student.edit', compact('student', 'subjects', 'classNames', 'sections', 'groups', 'guardians'));
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $student = Student::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'guardian_id' => 'required',
                'admission_date' => 'required|date',
                'dob' => 'required|date',
                'gender' => 'required|integer',
                'blood_group_id' => 'required|string',
                'religion' => 'required|string',
                'email' => 'nullable|email|unique:students,email,' . $id,
                'phone' => 'nullable|string|unique:students,phone,' . $id,
                'address' => 'required|string',
                'city' => 'required|string',
                'className' => 'required|integer',
                'section' => 'required|integer',
                'optional_subject_id' => 'nullable|integer',
                'reg_no' => 'nullable|string',
                'roll' => 'nullable|string',
                'photo' => 'nullable',
                'username' => 'nullable|string|unique:students,username,' . $id,
                'password' => 'nullable|string|min:6',
            ]);

            // Handle Photo Upload
            if ($request->hasFile('photo')) {
                // Delete previous photo if it exists
                if ($student->photo && file_exists(public_path('uploads/students/' . $student->photo))) {
                    unlink(public_path('uploads/students/' . $student->photo));
                }

                // Store new photo
                $fileName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('uploads/students'), $fileName);
                $student->photo = $fileName;
            }

            // Update Student
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
            $student->class_id = $request->className;
            $student->section_id = $request->section;
            $student->group = $request->group;
            $student->optional_subject_id = $request->optional_subject_id;
            $student->reg_no = $request->reg_no;
            $student->roll = $request->roll;
            $student->extra_curricular_activities = $request->extra_curricular_activities;
            $student->remarks = $request->remarks;
            $student->username = $request->username;
            $student->password = $request->password ? Hash::make($request->password) : $student->password;
            $student->status = 1;
            $student->updated_by = auth()->id();

            $student->save();

            toastr()->success('Data has been updated successfully!');
            return redirect()->route('student.index');
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy($id)
    {
        try{
            $student = Student::find($id);
            if ($student->photo && file_exists(public_path('uploads/students/' . $student->photo))) {
                unlink(public_path('uploads/students/' . $student->photo));
            }
            $student->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->route('student.index');
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);  //when catch(\Exception $e)
            return redirect()->back();
        }
    }
}
