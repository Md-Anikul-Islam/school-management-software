<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassName;
use App\Models\Ebooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EbooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('ebooks-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Ebooks';
        if (auth()->user()->can('Super Admin')) {
            $ebooks = Ebooks::get();
        } else {
            $ebooks = Ebooks::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.ebooks.index', compact('pageTitle', 'ebooks'));
    }

    public function create()
    {
        if (!Gate::allows('ebooks-create')) {
            return redirect()->route('unauthorized.action');
        }
        $classes = ClassName::all();
        return view('admin.pages.ebooks.add', compact('classes'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'author' => 'required',
                'class_id' => 'required',
                'cover_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'file' => 'required|mimes:pdf',
            ]);

            $ebook = new Ebooks();
            $ebook->name = $request->name;
            $ebook->author = $request->author;
            $ebook->class_id = $request->class_id;
            $ebook->school_id = Auth::user()->school_id ?? Auth::id();
            $ebook->created_by = Auth::id();

            if ($request->hasFile('cover_photo')) {
                $file = $request->file('cover_photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ebooks'), $filename);
                $ebook->cover_photo = $filename;
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ebooks'), $filename);
                $ebook->file = $filename;
            }

            $ebook->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('ebooks-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $classes = ClassName::all();
        $ebook = Ebooks::find($id);
        return view('admin.pages.ebooks.edit', compact('ebook', 'classes'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'author' => 'required',
                'class_id' => 'required',
                'cover_photo' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
                'file' => 'mimes:pdf',
            ]);

            $ebook = Ebooks::find($id);
            $ebook->name = $request->name;
            $ebook->author = $request->author;
            $ebook->class_id = $request->class_id;
            $ebook->school_id = Auth::user()->school_id ?? Auth::id();
            $ebook->updated_by = Auth::id();

            if ($request->hasFile('cover_photo')) {
                if ($ebook->cover_photo) {
                    unlink(public_path('uploads/ebooks/' . $ebook->cover_photo));
                }
                $file = $request->file('cover_photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ebooks'), $filename);
                $ebook->cover_photo = $filename;
            }

            if ($request->hasFile('file')) {
                if ($ebook->file) {
                    unlink(public_path('uploads/ebooks/' . $ebook->file));
                }
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ebooks'), $filename);
                $ebook->file = $filename;
            }

            $ebook->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function view(Ebooks $ebook)
    {
        if (!Gate::allows('ebooks-view')) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        $filePath = public_path('uploads/ebooks/' . $ebook->file);

        if (!file_exists($filePath)) {
            abort(Response::HTTP_NOT_FOUND, 'Ebook file not found.');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $ebook->name . '.pdf"',
        ]);
    }

    public function destroy($id)
    {
        if (!Gate::allows('ebooks-delete')) {
            return redirect()->route('unauthorized.action');
        }
        $ebook = Ebooks::find($id);
        if ($ebook->cover_photo) {
            unlink(public_path('uploads/ebooks/' . $ebook->cover_photo));
        }
        if ($ebook->file) {
            unlink(public_path('uploads/ebooks/' . $ebook->file));
        }
        $ebook->delete();
        toastr()->success('Data has been deleted successfully!');
        return redirect()->back();
    }
}
