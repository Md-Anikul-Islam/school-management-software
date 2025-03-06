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
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong! Please try again');
            return redirect()->back();
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
                'name' => 'required',
                'roll' => 'required',
                'email' => 'required',
            ]);

            $student = Student::find($id);

            $filename = $request->photo ?? "";

            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/students/' . $student->photo))) {
                    File::delete(public_path('uploads/students/' . $student->photo));
                }
                $file = $request->file('photo');
                $filename = date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/students/'), $filename);
            }

            $student->photo = $filename;
            $student->name = $request->name;
            $student->roll = $request->roll;
            $student->email = $request->email;
            $student->updated_by = Auth::id();
            $student->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong! Please try again');
            return redirect()->back();
        }
    }

    public function update_status(Request $request, string $id)
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
    public function destroy(string $id)
    {
        try {
            $student = Student::find($id);
            $student->delete();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong! Please try again');
            return redirect()->back();
        }
    }
}
