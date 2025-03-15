<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\SectionName;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('mark-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Marks List';
        $marks = Mark::all();
        return view('admin.pages.mark.index', compact('pageTitle', 'marks'));
    }

    public function create()
    {
        $classes = ClassName::all();
        $exams = Exam::all();
        $sections = SectionName::all();
        $subjects = Subject::all();
        return view('admin.pages.mark.add', compact('classes', 'exams', 'sections', 'subjects'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required',
            ]);
            $mark = new Mark();
            $mark->name = $request->name;
            $mark->created_by = Auth::id();
            $mark->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function edit($id)
    {
        $mark = Mark::find($id);
        return view('admin.pages.mark.edit', compact('mark'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required',
            ]);
            $mark = Mark::find($id);
            $mark->name = $request->name;
            $mark->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function destroy($id)
    {
        try{
            $mark = Mark::find($id);
            $mark->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }
}
