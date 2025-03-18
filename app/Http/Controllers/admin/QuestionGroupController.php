<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuestionGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('question-group-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if(auth()->user()->hasRole('Super Admin')) {
            $questionGroups = QuestionGroup::all();
        } else {
            $questionGroups = QuestionGroup::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.questionGroup.index', compact('questionGroups'));
    }

    public function create()
    {
        if (!Gate::allows('question-group-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.questionGroup.add');
    }

    public function store(Request $request)
    {
        try{
            $questionGroup = new QuestionGroup();
            $questionGroup->title = $request->title;
            $questionGroup->school_id = Auth::user()->school_id ?? Auth::id();
            $questionGroup->created_by = Auth::user()->id;
            $questionGroup->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('question-group-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $questionGroup = QuestionGroup::find($id);
        return view('admin.pages.questionGroup.edit', compact('questionGroup'));
    }

    public function update(Request $request, $id)
    {
        try{
            $questionGroup = QuestionGroup::find($id);
            $questionGroup->title = $request->title;
            $questionGroup->school_id = Auth::user()->school_id ?? Auth::id();
            $questionGroup->updated_by = Auth::user()->id;
            $questionGroup->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('question-group-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $questionGroup = QuestionGroup::find($id);
            $questionGroup->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
