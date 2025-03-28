<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('teacher-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Teacher List';
        if(auth()->user()->hasRole('Super Admin')){
            $teachers = Teacher::latest()->get();
        } else {
            $teachers = Teacher::where('school_id', Auth::id())->orWhere('school_id', Auth::user()->school_id)->get();
        }
        return view('admin.pages.teacher.index', compact('teachers', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('teacher-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.teacher.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'designation' => 'required',
                'dob' => 'required',
                'email' => 'required',
                'joining_date' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);
            $teacher = new Teacher();
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/teachers/', $fileName);
            }
            $teacher->name = $request->name;
            $teacher->designation = $request->designation;
            $teacher->dob = $request->dob;
            $teacher->gender = $request->gender;
            $teacher->religion = $request->religion;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->joining_date = $request->joining_date;
            $teacher->photo = $fileName;
            $teacher->username = $request->username;
            $teacher->password = $request->password;
            $teacher->school_id = Auth::user()->school_id ?? Auth::id();
            $teacher->created_by = Auth::id();
            $teacher->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }

    }

    public function updateRoutine(Request $request, $id)
    {
        try {
            $request->validate([
                'routine' => 'required',
            ]);
            $teacher = Teacher::find($id);
            $teacher->routine = $request->routine;
            $teacher->save();
            toastr()->success('Routine has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png',
        ]);

        $teacher = Teacher::findOrFail($id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Correct file name with extension
            $filePath = $file->move('uploads/documents', $fileName); // Move the file with the correct name

            Document::create([
                'title' => $fileName,
                'file_path' => $filePath,
                'uploader_id' => $teacher->id . '_' . $teacher->email,
            ]);

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    public function downloadDocument($id)
    {
        $document = Document::findOrFail($id);
        $filePath = public_path($document->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!Gate::allows('teacher-show')) {
            return redirect()->route('unauthorized.action');
        }
        $teacher = Teacher::findOrFail($id);
        $documents = Document::where('uploader_id', $teacher->id . '_' . $teacher->email)->get();
        return view('admin.pages.teacher.show', compact('teacher', 'documents'));
    }

    public function downloadProfilePdf($id)
    {
        $teacher = Teacher::findOrFail($id);

        $pdf = Pdf::loadView('admin.pages.teacher.teacher_profile_pdf', compact('teacher'));

        return $pdf->download('teacher_profile_' . $teacher->name . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Gate::allows('teacher-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $teacher = Teacher::find($id);
        return view('admin.pages.teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'designation' => 'required',
                'dob' => 'required',
                'email' => 'required',
                'joining_date' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);
            $teacher = Teacher::find($id);

            $fileName = $request->photo ?? "";

            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/teachers/' . $teacher->photo))) {
                    File::delete(public_path('uploads/teachers/' . $teacher->photo));
                }
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/teachers/'), $fileName);
            }
            $teacher->name = $request->name;
            $teacher->designation = $request->designation;
            $teacher->dob = $request->dob;
            $teacher->gender = $request->gender;
            $teacher->religion = $request->religion;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->joining_date = $request->joining_date;
            $teacher->photo = $fileName;
            $teacher->username = $request->username;
            $teacher->password = $request->password;
            $teacher->school_id = Auth::user()->school_id ?? Auth::id();
            $teacher->created_by = Auth::id();
            $teacher->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function update_status($id)
    {
        try {
            $teacher = Teacher::find($id);
            $teacher->status = !$teacher->status;
            $teacher->save();
            toastr()->success('Status has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Gate::allows('teacher-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $teacher = Teacher::find($id);
            if (File::exists(public_path('uploads/teachers/' . $teacher->photo))) {
                File::delete(public_path('uploads/teachers/' . $teacher->photo));
            }
            $teacher->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
