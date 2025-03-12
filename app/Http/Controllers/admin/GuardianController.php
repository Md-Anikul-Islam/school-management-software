<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
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
        $guardians = Guardian::all();
        return view('admin.pages.guardian.index', compact('pageTitle', 'guardians'));
    }

    public function create()
    {
        $pageTitle = 'Add Guardian';
        return view('admin.pages.guardian.add', compact('pageTitle'));
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
                'photo' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            $guardian = new Guardian();
            $guardian->name = $request->name;
            $guardian->father_name = $request->father_name;
            $guardian->mother_name = $request->mother_name;
            $guardian->father_profession = $request->father_profession;
            $guardian->mother_profession = $request->mother_profession;
            $guardian->email = $request->email;
            $guardian->phone = $request->phone;
            $guardian->address = $request->address;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/guardians/', $fileName);
                $guardian->photo = $fileName;
            }
            $guardian->username = $request->username;
            $guardian->password = Hash::make($request->password);
            $guardian->school_id = Auth::user()->school_id ?? Auth::id();
            $guardian->created_by = Auth::user()->id;
            $guardian->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function show($id)
    {
        $pageTitle = 'Guardian Details';
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return redirect()->back()->with('error', 'Guardian not found.');
        }
        return view('admin.pages.guardian.show', compact('pageTitle', 'guardian'));
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Guardian';
        $guardian = Guardian::find($id);
        return view('admin.pages.guardian.edit', compact('pageTitle', 'guardian'));
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
                'photo' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);


            $guardian = Guardian::find($id);
            $guardian->name = $request->name;
            $guardian->father_name = $request->father_name;
            $guardian->mother_name = $request->mother_name;
            $guardian->father_profession = $request->father_profession;
            $guardian->mother_profession = $request->mother_profession;
            $guardian->email = $request->email;
            $guardian->phone = $request->phone;
            $guardian->address = $request->address;
            if ($request->hasFile('photo')) {
                if (File::exists(public_path('uploads/guardians/' . $guardian->photo))) {
                    File::delete(public_path('uploads/guardians/' . $guardian->photo));
                }
                $file = $request->file('photo');
                $filename = date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/guardians/'), $filename);
                $guardian->photo = $filename;
            }
            $guardian->username = $request->username;
            $guardian->password = Hash::make($request->password);
            $guardian->school_id = Auth::user()->school_id ?? Auth::id();
            $guardian->created_by = Auth::user()->id;
            $guardian->save();

            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $guardian = Guardian::find($id);
            $guardian->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
