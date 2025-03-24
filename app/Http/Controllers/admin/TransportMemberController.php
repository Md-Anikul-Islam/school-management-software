<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transport;
use App\Models\TransportMember;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\ClassName;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransportMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('transport-member-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Transport Member List';
        $classes = ClassName::all();
        $students = Student::query(); // Start with a Student query

        if ($request->class_id !== null && $request->class_id !== '') {
            $students->where('class_id', $request->class_id);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $students->where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id);
        }

        $students = $students->get();

        $transportMembers = TransportMember::with('student', 'transport')->get();

        return view('admin.pages.transportMember.index', compact('transportMembers', 'pageTitle', 'classes', 'students'));
    }

    public function create($studentId)
    {
        if (!Gate::allows('transport-member-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $transports = Transport::all();
            $student = Student::find($studentId);
        } else {
            $transports = Transport::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
            $student = Student::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->find($studentId);
        }
        return view('admin.pages.transportMember.add', compact('studentId', 'transports', 'student'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'transport_id' => 'required|exists:transports,id',
                'fare' => 'required|numeric',
            ]);

            TransportMember::create([
                'student_id' => $request->student_id,
                'transport_id' => $request->transport_id,
                'fare' => $request->fare,
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

    public function show(TransportMember $transportMember)
    {
        if (!Gate::allows('transport-member-show')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.transportMember.show', compact('transportMember'));
    }

    public function edit(TransportMember $transportMember)
    {
        if (!Gate::allows('transport-member-edit')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $transports = Transport::all();
        } else {
            $transports = Transport::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.transportMember.edit', compact('transportMember', 'transports'));
    }

    public function update(Request $request, TransportMember $transportMember)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'transport_id' => 'required|exists:transports,id',
                'fare' => 'required|numeric',
            ]);

            $transportMember->update([
                'student_id' => $request->student_id,
                'transport_id' => $request->transport_id,
                'fare' => $request->fare,
                'updated_by' => Auth::id(),
            ]);
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy(TransportMember $transportMember)
    {
        if(!Gate::allows('transport-member-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $transportMember->delete();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function getFare($transportId)
    {
        $transport = Transport::find($transportId);
        if ($transport) {
            return response()->json(['fare' => $transport->route_fare]);
        } else {
            return response()->json(['fare' => null]);
        }
    }

    public function pdf($id)
    {
        $transportMember = TransportMember::find($id);
        $pdf = PDF::loadView('admin.pages.transportMember.pdf', compact('transportMember'));
        return $pdf->download('transport_member_' . $transportMember->transport->id . '.pdf'); // Corrected line
    }
}
