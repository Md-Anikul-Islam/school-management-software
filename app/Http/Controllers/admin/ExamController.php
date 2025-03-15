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
        if(auth()->user()->hasRole('Super Admin')) {
            $exams = Exam::all();
        } else {
            $exams = Exam::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.exam.index', compact('pageTitle', 'exams'));
    }

    public function create()
    {
        if (!Gate::allows('exam-create')) {
            return redirect()->route('unauthorized.action');
        }
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
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('exam-edit')) {
            return redirect()->route('unauthorized.action');
        }
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
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
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
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
