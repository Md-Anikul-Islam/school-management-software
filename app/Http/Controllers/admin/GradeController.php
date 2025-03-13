<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('grade-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Grade List';
        $grades = Grade::all();
        return view('admin.pages.grade.index', compact('pageTitle', 'grades'));
    }

    public function create()
    {
        $pageTitle = 'Add Grade';
        return view('admin.pages.grade.add', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'grade_name' => 'required',
                'grade_point' => 'required',
                'mark_from' => 'required',
                'mark_upto' => 'required',
            ]);

            $grade = new Grade();
            $grade->grade_name = $request->grade_name;
            $grade->grade_point = $request->grade_point;
            $grade->mark_from = $request->mark_from;
            $grade->mark_upto = $request->mark_upto;
            $grade->note = $request->note;
            $grade->school_id = Auth::user()->school_id ?? Auth::id();
            $grade->created_by = Auth::user()->id;
            $grade->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Grade';
        $grade = Grade::find($id);
        return view('admin.pages.grade.edit', compact('pageTitle', 'grade'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'grade_name' => 'required',
                'grade_point' => 'required',
                'mark_from' => 'required',
                'mark_upto' => 'required',
            ]);

            $grade = Grade::find($id);
            $grade->grade_name = $request->grade_name;
            $grade->grade_point = $request->grade_point;
            $grade->mark_from = $request->mark_from;
            $grade->mark_upto = $request->mark_upto;
            $grade->note = $request->note;
            $grade->school_id = Auth::user()->school_id ?? Auth::id();
            $grade->updated_by = Auth::id();
            $grade->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $grade = Grade::find($id);
            $grade->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
