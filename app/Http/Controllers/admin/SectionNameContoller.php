<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\SectionName;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SectionNameContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('section-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Section List';
        $classes = ClassName::all();

        $sections = SectionName::join('class_names', 'section_names.class_id', '=', 'class_names.id')
            ->select('section_names.*', 'class_names.name as class_name');

        if ($request->filled('class_id')) {
            $sections->where('section_names.class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $sections->where('section_names.school_id', Auth::id());
        }

        $sections = $sections->latest()->get();

        return view('admin.pages.section.index', compact('sections', 'pageTitle', 'classes'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $classes = ClassName::all();
            $teachers = Teacher::all();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->get();
            $teachers = Teacher::where('school_id', Auth::id())->get();
        }
        return view('admin.pages.section.add', compact('classes', 'teachers'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'capacity' => 'required',
                'class_id' => 'required',
                'teacher_id' => 'required',
            ]);
            $section = new SectionName();
            $section->name = $request->name;
            $section->capacity = $request->capacity;
            $section->class_id = $request->class_id;
            $section->teacher_id = $request->teacher_id;
            $section->note = $request->note;
            $section->school_id = Auth::id();
            $section->created_by = Auth::id();
            $section->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $classes = ClassName::all();
            $teachers = Teacher::all();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->get();
            $teachers = Teacher::where('school_id', Auth::id())->get();
        }
        $section = SectionName::find($id);
        return view('admin.pages.section.edit', compact('section', 'classes', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'capacity' => 'required',
                'class_id' => 'required',
                'teacher_id' => 'required',
            ]);
            $section = SectionName::find($id);
            $section->name = $request->name;
            $section->capacity = $request->capacity;
            $section->class_id = $request->class_id;
            $section->teacher_id = $request->teacher_id;
            $section->note = $request->note;
            $section->school_id = Auth::id();
            $section->updated_by = Auth::id();
            $section->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $section = SectionName::find($id);
            $section->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

}
