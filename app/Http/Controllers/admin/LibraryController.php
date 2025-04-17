<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('library-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Library List';
        if (auth()->user()->hasRole('Super Admin')){
            $libraries = Library::all();
        } else {
            $libraries = Library::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.library.index', compact('libraries', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('library-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.library.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'code' => 'required',
                'fee' => 'required',
            ]);
            $library = new Library();
            $library->title = $request->title;
            $library->code = $request->code;
            $library->fee = $request->fee;
            $library->school_id = Auth::user()->school_id ?? Auth::id();
            $library->created_by = Auth::id();
            $library->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('library-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $library = Library::find($id);
        return view('admin.pages.library.edit', compact('library'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'code' => 'required',
                'fee' => 'required',
            ]);
            $library = Library::findOrFail($id);
            $library->title = $request->title;
            $library->code = $request->code;
            $library->fee = $request->fee;
            $library->school_id = Auth::user()->school_id ?? Auth::id();
            $library->updated_by = Auth::id();
            $library->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('library-delete')) {
            return redirect()->route('unauthorized.action');
        }
        $library = Library::findOrFail($id);
        $library->delete();
        toastr()->success('Data has been deleted successfully!');
        return redirect()->back();
    }
}
