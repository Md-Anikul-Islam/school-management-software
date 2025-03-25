<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\HostelCategory;
use App\Models\HostelMember;
use App\Models\Student;
use App\Models\ClassName;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HostelMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('hostel-member-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Hostel Member List';
        $classes = ClassName::all();
        $students = Student::query();

        if ($request->class_id !== null && $request->class_id !== '') {
            $students->where('class_id', $request->class_id);
        }

        // Add hostel and category filtering
        if ($request->hostel_id !== null && $request->hostel_id !== '') {
            $studentIds = HostelMember::where('hostel_id', $request->hostel_id)->pluck('student_id');
            $students->whereIn('id', $studentIds);
        }

        if ($request->category_id !== null && $request->category_id !== '') {
            $studentIds = HostelMember::where('hostel_category_id', $request->category_id)->pluck('student_id');
            $students->whereIn('id', $studentIds);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $students->where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id);
        }

        $students = $students->get();

        $hostelMembers = HostelMember::with('student', 'hostel', 'hostelCategory')->get();

        // Fetch hostels and categories for filtering
        if (auth()->user()->hasRole('Super Admin')) {
            $hostels = Hostel::all();
            $categories = HostelCategory::all();
        } else {
            $hostels = Hostel::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
            $categories = HostelCategory::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }

        return view('admin.pages.hostelMember.index', compact('hostelMembers', 'pageTitle', 'classes', 'students', 'hostels', 'categories'));
    }
    public function create($studentId)
    {
        if (!Gate::allows('hostel-member-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $hostels = Hostel::all();
            $hostelCategories = HostelCategory::all();
            $student = Student::find($studentId);
        } else {
            $hostels = Hostel::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
            $hostelCategories = HostelCategory::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
            $student = Student::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->find($studentId);
        }
        return view('admin.pages.hostelMember.add', compact('studentId', 'hostels', 'hostelCategories', 'student'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'hostel_id' => 'required|exists:hostels,id',
                'hostel_category_id' => 'required|exists:hostel_categories,id',
            ]);

            HostelMember::create([
                'student_id' => $request->student_id,
                'hostel_id' => $request->hostel_id,
                'hostel_category_id' => $request->hostel_category_id,
                'school_id' => Auth::user()->school_id ?? Auth::id(),
                'created_by' => Auth::id(),
            ]);
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show(HostelMember $hostelMember)
    {
        if (!Gate::allows('hostel-member-show')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.hostelMember.show', compact('hostelMember'));
    }

    public function edit(HostelMember $hostelMember)
    {
        if (!Gate::allows('hostel-member-edit')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $hostels = Hostel::all();
            $hostelCategories = HostelCategory::all();
//            dd($hostelCategories);
        } else {
            $hostels = Hostel::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
            $hostelCategories = HostelCategory::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.hostelMember.edit', compact('hostelMember', 'hostels', 'hostelCategories'));
    }

    public function update(Request $request, HostelMember $hostelMember)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'hostel_id' => 'required|exists:hostels,id',
                'hostel_category_id' => 'required|exists:hostel_categories,id',
            ]);

            $hostelMember->update([
                'student_id' => $request->student_id,
                'hostel_id' => $request->hostel_id,
                'hostel_category_id' => $request->hostel_category_id,
                'updated_by' => Auth::id(),
            ]);
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy(HostelMember $hostelMember)
    {
        if (!Gate::allows('hostel-member-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $hostelMember->delete();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function pdf($id)
    {
        $hostelMember = HostelMember::find($id);
        $pdf = PDF::loadView('admin.pages.hostelMember.pdf', compact('hostelMember'));
        return $pdf->download('hostel_member_' . $hostelMember->hostel->id . '.pdf');
    }

    public function getHostelCategories($hostelId)
    {
        $categories = HostelCategory::where('hostel_id', $hostelId)->get();
        return response()->json($categories);
    }
}
