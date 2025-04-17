<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\LibraryMember;
use App\Models\ClassName;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LibraryMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('library-member-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Library LibraryMember List';
        $classes = ClassName::all();
        $students = Student::query();

        if ($request->class_id !== null && $request->class_id !== '') {
            $students->where('class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $students->where('school_id', Auth::user()->school_id); // Corrected line
        }

        $students = $students->get();

        $libraryMember = LibraryMember::with('library')->get();

        return view('admin.pages.member.index', compact('pageTitle', 'students', 'libraryMember', 'classes'));
    }

    public function create($studentId)
    {
        if (!Gate::allows('library-member-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $libraries = Library::all();
            $student = Student::find($studentId);
        } else {
            $libraries = Library::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
            $student = Student::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.member.add', compact('libraries', 'student', 'studentId')); // Pass $studentId to the view
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'library_id' => 'required|exists:libraries,id',
            ]);

            LibraryMember::create([
                'student_id' => $request->student_id,
                'library_id' => $request->library_id,
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

    public function show(LibraryMember $libraryMember)
    {
        if (!Gate::allows('library-member-show')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.member.show', compact('libraryMember'));
    }

    public function edit(LibraryMember $libraryMember)
    {
        if (!Gate::allows('library-member-edit')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $libraries = Library::all();
        } else {
            $libraries = Library::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.member.edit', compact('libraryMember', 'libraries'));
    }

    public function update(Request $request, LibraryMember $libraryMember)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'library_id' => 'required|exists:libraries,id',
            ]);

            $libraryMember->update([
                'student_id' => $request->student_id,
                'library_id' => $request->library_id,
                'updated_by' => Auth::id(),
            ]);
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy(LibraryMember $libraryMember)
    {
        if (!Gate::allows('library-member-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $libraryMember->delete();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function pdf($id)
    {
        $libraryMember = LibraryMember::find($id);
        $pdf = PDF::loadView('admin.pages.member.pdf', compact('libraryMember'));
        return $pdf->download('library_member_' . $libraryMember->library->code . '.pdf');
    }

    public function getLibraryDetails($libraryId)
    {
        $library = Library::find($libraryId);
        if ($library) {
            return response()->json(['code' => $library->code, 'fee' => $library->fee]);
        } else {
            return response()->json(['code' => '', 'fee' => '']);
        }
    }

}
