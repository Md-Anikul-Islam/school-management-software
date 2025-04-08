<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('issue-list',)) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

//    public function index()
//    {
//        $pageTitle = 'Issue List';
//        if(auth()->user()->can('Super Admin')) {
//            $issues = Issue::all();
//        } else {
//            $issues = Issue::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
//        }
//        return view('admin.pages.issue.index', compact('issues', 'pageTitle'));
//    }

    public function index(Request $request)
    {
        $pageTitle = 'Issue List';
        $searchLibraryId = $request->input('library_id');

        $issuesQuery = Issue::query();

        if (!auth()->user()->can('Super Admin')) {
            $issuesQuery->where('school_id', Auth::user()->school_id)
                ->orWhere('school_id', Auth::id());
        }

        if ($searchLibraryId) {
            $issues = $issuesQuery->where('library_id', $searchLibraryId)
                ->with('book')
                ->latest('created_at')
                ->get();
        } else {
            $issues = $issuesQuery->with('book')
                ->latest('created_at')
                ->get();
        }

        return view('admin.pages.issue.index', compact('issues', 'pageTitle', 'searchLibraryId'));
    }


    public function create()
    {
        if(!Gate::allows('issue-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->can('Super Admin')) {
            $books = Books::all();
        } else{
            $books = Books::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.issue.add', compact('books'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'library_id' => 'required',
                'book_id' => 'required',
                'author' => 'required',
                'subject_code' => 'required',
                'serial_no' => 'required',
                'due_date' => 'required',
                'note' => 'nullable',
            ]);
            $issue = new Issue();
            $issue->library_id = $request->library_id;
            $issue->book_id = $request->book_id;
            $issue->author = $request->author;
            $issue->subject_code = $request->subject_code;
            $issue->serial_no = $request->serial_no;
            $issue->due_date = $request->due_date;
            $issue->note = $request->note;
            $issue->school_id = Auth::user()->school_id ?? Auth::id();
            $issue->created_by = Auth::id();
            $issue->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('issue-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $issue = Issue::find($id);
        if(auth()->user()->can('Super Admin')) {
            $books = Books::all();
        } else{
            $books = Books::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.issue.edit', compact('issue', 'books'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'library_id' => 'required',
                'book_id' => 'required',
                'author' => 'required',
                'subject_code' => 'required',
                'serial_no' => 'required',
                'due_date' => 'required',
                'note' => 'nullable',
            ]);
            $issue = Issue::find($id);
            $issue->library_id = $request->library_id;
            $issue->book_id = $request->book_id;
            $issue->author = $request->author;
            $issue->subject_code = $request->subject_code;
            $issue->serial_no = $request->serial_no;
            $issue->due_date = $request->due_date;
            $issue->note = $request->note;
            $issue->school_id = Auth::user()->school_id ?? Auth::id();
            $issue->updated_by = Auth::id();
            $issue->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('issue-delete')) {
            return redirect()->route('unauthorized.action');
        }
        $issue = Issue::find($id);
        $issue->delete();
        toastr()->success('Data has been deleted successfully!');
        return redirect()->back();
    }
}
