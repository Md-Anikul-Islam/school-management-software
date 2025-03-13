<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Guardian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('guardian-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Guardian List';
        if(auth()->user()->hasRole('Super Admin')) {
            $guardians = Guardian::all();
        } else {
            $guardians = Guardian::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.guardian.index', compact('pageTitle', 'guardians'));
    }

    public function create()
    {
        return view('admin.pages.guardian.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'father_profession' => 'required',
                'mother_profession' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            $guardian = new Guardian();
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/guardians/', $fileName);
            }
            $guardian->name = $request->name;
            $guardian->father_name = $request->father_name;
            $guardian->mother_name = $request->mother_name;
            $guardian->father_profession = $request->father_profession;
            $guardian->mother_profession = $request->mother_profession;
            $guardian->email = $request->email;
            $guardian->phone = $request->phone;
            $guardian->address = $request->address;
            $guardian->photo = $fileName;
            $guardian->username = $request->username;
            $guardian->password = $request->password;
            $guardian->school_id = Auth::user()->school_id ?? Auth::id();
            $guardian->created_by = Auth::user()->id;
            $guardian->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $guardian = Guardian::find($id);
        $documents = Document::where('uploader_id', $guardian->id . '_' . $guardian->phone)->get();
        return view('admin.pages.guardian.show', compact( 'guardian', 'documents'));
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png',
        ]);

        $guardian = Guardian::findOrFail($id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Correct file name with extension
            $filePath = $file->move('uploads/guardians', $fileName); // Move the file with the correct name

            Document::create([
                'title' => $fileName,
                'file_path' => $filePath,
                'uploader_id' => $guardian->id . '_' . $guardian->phone,
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

    public function edit($id)
    {
        $guardian = Guardian::find($id);
        return view('admin.pages.guardian.edit', compact('guardian'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'father_profession' => 'required',
                'mother_profession' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);


            $guardian = Guardian::find($id);
            $fileName = $request->photo ?? "";

            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/guardians/' . $guardian->photo))) {
                    File::delete(public_path('uploads/guardians/' . $guardian->photo));
                }
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/guardians/'), $fileName);
            }
            $guardian->name = $request->name;
            $guardian->father_name = $request->father_name;
            $guardian->mother_name = $request->mother_name;
            $guardian->father_profession = $request->father_profession;
            $guardian->mother_profession = $request->mother_profession;
            $guardian->email = $request->email;
            $guardian->phone = $request->phone;
            $guardian->address = $request->address;
            $guardian->photo = $fileName;
            $guardian->username = $request->username;
            $guardian->password = $request->password;
            $guardian->school_id = Auth::user()->school_id ?? Auth::id();
            $guardian->created_by = Auth::user()->id;
            $guardian->save();

            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function update_status($id)
    {
        try {
            $guardian = Guardian::find($id);
            $guardian->status = !$guardian->status;
            $guardian->save();
            toastr()->success('Status has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function downloadProfilePdf($id)
    {
        $guardian = Guardian::findOrFail($id);

        $pdf = Pdf::loadView('admin.pages.guardian.guardian_profile_pdf', compact('guardian'));

        return $pdf->download('guardian_profile_' . $guardian->name . '.pdf');
    }

    public function destroy($id)
    {
        try {
            $guardian = Guardian::find($id);
            $guardian->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
