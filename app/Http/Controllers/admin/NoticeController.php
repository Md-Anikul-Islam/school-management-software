<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('notice-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Notice List';
        if (auth()->user()->role == 'Super Admin') {
            $notices = Notice::all();
        } else {
            $notices = Notice::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.notice.index', compact('pageTitle', 'notices'));
    }

    public function create()
    {
        return view('admin.pages.notice.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'date' => 'required',
                'notice' => 'required',
            ]);
            $notice = new Notice();
            $notice->title = $request->title;
            $notice->date = $request->date;
            $notice->notice = $request->notice;
            $notice->school_id = Auth::user()->school_id ?? Auth::id();
            $notice->created_by = Auth::id();
            $notice->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $notice = Notice::find($id);
        return view('admin.pages.notice.show', compact('notice'));
    }

    public function edit($id)
    {
        $notice = Notice::find($id);
        $editorId = (int) $id;
        return view('admin.pages.notice.edit', compact('notice', 'editorId'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'date' => 'required',
                'notice' => 'required',
            ]);
            $notice = Notice::find($id);
            $notice->title = $request->title;
            $notice->date = $request->date;
            $notice->notice = $request->notice;
            $notice->school_id = Auth::user()->school_id ?? Auth::id();
            $notice->updated_by = Auth::id();
            $notice->save();
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
            $notice = Notice::find($id);
            $notice->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function pdf($id)
    {
        $notice = Notice::find($id);
        $createdBy = User::find($notice->created_by); // Assuming 'created_by' stores the user ID
        $pdf = PDF::loadView('admin.pages.notice.pdf', compact('notice', 'createdBy'));
        return $pdf->download('notice_' . $notice->id . '.pdf');
    }
}
