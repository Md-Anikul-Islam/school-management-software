<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ChildCare;
use App\Models\ClassName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ChildCareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('childcare-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Child Care';
        if(auth()->user()->can('Super Admin')) {
            $childCares = ChildCare::get();
        } else {
            $childCares = ChildCare::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.childCare.index', compact('childCares', 'pageTitle'));
    }

    public function create()
    {
        $classes = ClassName::all();
        if (auth()->user()->can('Super Admin')) {
            $students = Student::all();
        } else {
            $students = Student::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.childCare.add', compact('classes', 'students'));
    }

    public function store(Request $request)
    {
        if(!Gate::allows('childcare-create')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $request->validate([
                'class_id' => 'required',
                'student_id' => 'required',
                'receiver_name' => 'required',
                'phone' => 'required',
                'drop_time' => 'required',
                'receive_time' => 'required',
            ]);

            $childCare = new ChildCare();
            $childCare->class_id = $request->class_id;
            $childCare->student_id = $request->student_id;
            $childCare->receiver_name = $request->receiver_name;
            $childCare->phone = $request->phone;
            $childCare->drop_time = $request->drop_time;
            $childCare->receive_time = $request->receive_time;
            $childCare->comment = $request->comment;
            $childCare->school_id = Auth::user()->school_id ?? Auth::id();
            $childCare->created_by = Auth::id();
            $childCare->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('childcare-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $childCare = ChildCare::findOrFail($id);
        $classes = ClassName::all();
        if (auth()->user()->can('Super Admin')) {
            $students = Student::all();
        } else {
            $students = Student::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.childCare.edit', compact('childCare', 'classes', 'students'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'class_id' => 'required',
                'student_id' => 'required',
                'receiver_name' => 'required',
                'phone' => 'required',
                'drop_time' => 'required',
                'receive_time' => 'required',
            ]);

            $childCare = ChildCare::find($id);
            $childCare->class_id = $request->class_id;
            $childCare->student_id = $request->student_id;
            $childCare->receiver_name = $request->receiver_name;
            $childCare->phone = $request->phone;
            $childCare->drop_time = $request->drop_time;
            $childCare->receive_time = $request->receive_time;
            $childCare->comment = $request->comment;
            $childCare->school_id = Auth::user()->school_id ?? Auth::id();
            $childCare->updated_by = Auth::id();
            $childCare->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('childcare-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $childCare = ChildCare::find($id);
            $childCare->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function getStudentsByClass(Request $request)
    {
        $classId = $request->input('class_id');
        if ($classId) {
            if (auth()->user()->can('Super Admin')) {
                $students = Student::where('class_id', $classId)->pluck('name', 'id');
            } else {
                $students = Student::where('class_id', $classId)
                    ->where(function ($query) {
                        $query->where('school_id', Auth::user()->school_id)
                            ->orWhere('school_id', Auth::id());
                    })
                    ->pluck('name', 'id');
            }
            return response()->json($students);
        }
        return response()->json([]);
    }
}
