<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('media-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Media List';
        if(auth()->user()->hasRole('Super Admin')) {
            $mediaItems = Media::whereNull('parent_id')->get();
        } else {
            $mediaItems = Media::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->whereNull('parent_id')->get();
        }
        return view('admin.pages.media.index', compact('pageTitle', 'mediaItems'));
    }

    public function createFolder(Request $request)
    {
        try{
            $request->validate(['name' => 'required']);

            Media::create([
                'name' => $request->name,
                'type' => 'folder',
                'parent_id' => $request->parent_id,
            ]);

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'parent_id' => 'nullable|exists:media,id', // Corrected model name
            ]);

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/media'), $imageName);

            $mediaItem = Media::create([
                'name' => $imageName,
                'path' => '/uploads/media/' . $imageName,
                'type' => 'image',
                'parent_id' => $request->parent_id,
            ]);

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function showFolder(Media $folder)
    {
        if(auth()->user()->hasRole('Super Admin')) {
            $items = Media::where('parent_id', $folder->id)->get();
        } else {
            $items = Media::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->where('parent_id', $folder->id)->get();
        }
        return view('admin.pages.media.folder', compact('folder', 'items'));
    }

    public function createFolderForm(Media $folder)
    {
        return view('admin.pages.media.createFolder', compact('folder'));
    }

    public function destroy(Media $mediaItem)
    {
        if (!Gate::allows('media-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $mediaItem->delete();
            if(File::exists(public_path($mediaItem->path))) {
                File::delete(public_path($mediaItem->path));
            }
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
