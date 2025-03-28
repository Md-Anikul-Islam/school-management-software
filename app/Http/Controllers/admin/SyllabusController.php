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

        $syllabi = Syllabus::with('class');

        if ($request->class_id !== null && $request->class_id !== '') {
            $syllabi->where('class_id', $request->class_id);
        }

        if(!auth()->user()->hasRole('Super Admin')){
            $syllabi->where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id);
        }

        $syllabi = $syllabi->latest()->get();

        return view('admin.pages.syllabus.index', compact('syllabi', 'pageTitle', 'classes'));
    }


    public function create()
    {
        if (!Gate::allows('syllabus-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $classes = ClassName::all();
        } else {
            $classes = ClassName::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
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
            $syllabus->school_id = Auth::user()->school_id ?? Auth::id();
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
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('syllabus-edit')) {
            return redirect()->route('unauthorized.action');
        }
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
            $syllabus->school_id = Auth::user()->school_id ?? Auth::id();
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
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('syllabus-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $syllabus = Syllabus::find($id);
            if (File::exists(public_path('uploads/syllabus/' . $syllabus->file))) {
                File::delete(public_path('uploads/syllabus/' . $syllabus->file));
            }
            $syllabus->delete();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
