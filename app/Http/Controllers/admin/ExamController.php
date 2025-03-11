<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('exam-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Exams List';
        $exams = Exam::all();
        return view('admin.pages.exam.index', compact('pageTitle', 'exams'));
    }

    public function create()
    {
        return view('admin.pages.exam.add');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required',
            ]);
            $exam = new Exam();
            $exam->name = $request->name;
            $exam->date = $request->date;
            $exam->note = $request->note;
            $exam->do_not_delete = $request->has('do_not_delete') ? 1 : 0;;
            $exam->school_id = Auth::user()->school_id ?? Auth::id();
            $exam->created_by = Auth::id();
            $exam->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function edit($id)
    {
        $exam = Exam::find($id);
        return view('admin.pages.exam.edit', compact('exam'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required',
            ]);
            $exam = Exam::find($id);
            $exam->name = $request->name;
            $exam->date = $request->date;
            $exam->note = $request->note;
            $exam->do_not_delete = $request->has('do_not_delete') ? 1 : 0;
            $exam->school_id = Auth::user()->school_id ?? Auth::id();
            $exam->updated_by = Auth::id();
            $exam->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function destroy($id)
    {
        try{
            $exam = Exam::find($id);
            $exam->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }
}
