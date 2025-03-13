<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassNameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('class-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $classes = ClassName::latest()->get();
        return view('admin.pages.class.index', compact('classes'));
    }

    public function create()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $teachers = Teacher::latest()->get();
        } else {
            $teachers = Teacher::where('school_id', Auth::id())->get();
        }
        return view('admin.pages.class.add', compact('teachers'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'class_numeric' => 'required',
                'teacher_id' => 'required',
            ]);
            $class = new ClassName();
            $class->name = $request->name;
            $class->class_numeric = $request->class_numeric;
            $class->teacher_id = $request->teacher_id;
            $class->note = $request->note;
            $class->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $class = ClassName::find($id);
        if(auth()->user()->hasRole('Super Admin')){
            $teachers = Teacher::latest()->get();
        } else {
            $teachers = Teacher::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.class.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'class_numeric' => 'required',
                'teacher_id' => 'required',
            ]);
            $class = ClassName::find($id);
            $class->name = $request->name;
            $class->class_numeric = $request->class_numeric;
            $class->teacher_id = $request->teacher_id;
            $class->note = $request->note;
            $class->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try{
            $class = ClassName::find($id);
            $class->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
