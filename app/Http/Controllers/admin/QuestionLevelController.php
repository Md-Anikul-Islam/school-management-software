<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuestionLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('question-level-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if(auth()->user()->hasRole('Super Admin')) {
            $questionLevels = QuestionLevel::all();
        } else {
            $questionLevels = QuestionLevel::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.questionLevel.index', compact('questionLevels'));
    }

    public function create()
    {
        if (!Gate::allows('question-level-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.questionLevel.add');
    }

    public function store(Request $request)
    {
        try{
            $questionLevel = new QuestionLevel();
            $questionLevel->title = $request->title;
            $questionLevel->school_id = Auth::user()->school_id ?? Auth::id();
            $questionLevel->created_by = Auth::user()->id;
            $questionLevel->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('question-level-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $questionLevel = QuestionLevel::find($id);
        return view('admin.pages.questionLevel.edit', compact('questionLevel'));
    }

    public function update(Request $request, $id)
    {
        try{
            $questionLevel = QuestionLevel::find($id);
            $questionLevel->title = $request->title;
            $questionLevel->school_id = Auth::user()->school_id ?? Auth::id();
            $questionLevel->updated_by = Auth::user()->id;
            $questionLevel->save();
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
            $questionLevel = QuestionLevel::find($id);
            $questionLevel->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
