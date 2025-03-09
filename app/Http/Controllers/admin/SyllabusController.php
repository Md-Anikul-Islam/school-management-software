<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SyllabusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('syllabus-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Syllabus List';
        $classes = ClassName::all();

        $syllabi = Syllabus::join('class_names', 'syllabi.class_id', '=', 'class_names.id')
            ->select('syllabi.*', 'class_names.name as class_name');

        if ($request->filled('class_id')) {
            $syllabi->where('syllabi.class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $syllabi->where('syllabi.school_id', Auth::id());
        }

        $syllabi = $syllabi->latest()->get();

        return view('admin.pages.syllabus.index', compact('syllabi', 'pageTitle', 'classes'));
    }

    public function create()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $classes = ClassName::all();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->get();
        }
        return view('admin.pages.syllabus.add', compact('classes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'class_id' => 'required',
                'file' => 'required|mimes:pdf,doc,docx,',
            ]);
            $syllabus = new Syllabus();
            $syllabus->title = $request->title;
            $syllabus->description = $request->description;
            $syllabus->class_id = $request->class_id;
            $syllabus->date = date('Y-m-d');
            $syllabus->uploaded_by = Auth::id();
            $syllabus->school_id = Auth::id() ?? Auth::user()->school_id;
            $syllabus->created_by = Auth::id();
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/syllabus/'), $fileName);
                $syllabus->file = $fileName;
            }
            $syllabus->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        if(auth()->user()->hasRole('Super Admin')){
            $classes = ClassName::all();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->get();
        }
        $syllabus = Syllabus::find($id);
        return view('admin.pages.syllabus.edit', compact('syllabus', 'classes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'class_id' => 'required',
            ]);
            $syllabus = Syllabus::find($id);
            $syllabus->title = $request->title;
            $syllabus->description = $request->description;
            $syllabus->class_id = $request->class_id;
            $syllabus->date = date('Y-m-d');
            $syllabus->uploaded_by = Auth::id();
            $syllabus->school_id = Auth::id() ?? Auth::user()->school_id;
            $syllabus->updated_by = Auth::id();
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/syllabus/'), $fileName);
                $syllabus->file = $fileName;
            }
            $syllabus->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $syllabus = Syllabus::find($id);
            $syllabus->delete();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
