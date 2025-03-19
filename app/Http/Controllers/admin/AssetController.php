<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Models\AssetCategory;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;


class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('asset-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Asset List';
        if (auth()->user()->hasRole('Super Admin')) {
            $assets = Asset::all();
        } else {
            $assets = Asset::where('school_id', auth()->user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.asset.index', compact('assets', 'pageTitle'));
    }

    public function create()
    {
        if (!Gate::allows('asset-category-create')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $categories = AssetCategory::all();
            $locations = Location::all();
        } else {
            $categories = AssetCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $locations = Location::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.asset.add', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('asset-create')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $request->validate([
                'serial' => 'required',
                'title' => 'required',
                'status' => 'required',
                'condition' => 'required',
                'asset_category_id' => 'required',
                'location_id' => 'required',
            ]);
            $asset = new Asset();
            $asset->serial = $request->serial;
            $asset->title = $request->title;
            $asset->status = $request->status;
            $asset->condition = $request->condition;
            $asset->asset_category_id = $request->asset_category_id;
            $asset->location_id = $request->location_id;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/assets/'), $fileName);
                $asset->attachment = $fileName;
            }
            $asset->school_id = Auth::user()->school_id ?? Auth::id();
            $asset->created_by = Auth::id();
            $asset->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if (!Gate::allows('asset-show')) {
            return redirect()->route('unauthorized.action');
        }
        $asset = Asset::find($id);
        return view('admin.pages.asset.show', compact('asset'));
    }

    public function edit($id)
    {
        if (!Gate::allows('asset-edit')) {
            return redirect()->route('unauthorized.action');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $categories = AssetCategory::all();
            $locations = Location::all();
        } else {
            $categories = AssetCategory::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $locations = Location::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        $asset = Asset::find($id);
        return view('admin.pages.asset.edit', compact('asset', 'categories', 'locations'));
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('asset-edit')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $request->validate([
                'serial' => 'required',
                'title' => 'required',
                'status' => 'required',
                'condition' => 'required',
                'asset_category_id' => 'required',
                'location_id' => 'required',
            ]);
            $asset = Asset::find($id);
            $fileName = $request->attachment ?? "";

            if ($request->hasFile('attachment')) {
                if (File::exists(public_path('uploads/assets/' . $asset->photo))) {
                    File::delete(public_path('uploads/assets/' . $asset->photo));
                }
                $file = $request->file('attachment');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/assets/'), $fileName);
            }
            $asset->serial = $request->serial;
            $asset->title = $request->title;
            $asset->status = $request->status;
            $asset->condition = $request->condition;
            $asset->asset_category_id = $request->asset_category_id;
            $asset->location_id = $request->location_id;
            $asset->attachment = $fileName;
            $asset->school_id = Auth::user()->school_id ?? Auth::id();
            $asset->updated_by = Auth::id();
            $asset->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('asset-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try {
            $asset = Asset::find($id);
            $asset->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function downloadPdf($id)
    {
        if (!Gate::allows('asset-show')) {
            return redirect()->route('unauthorized.action');
        }
        $asset = Asset::find($id);
        $pdf = Pdf::loadView('admin.pages.asset.pdf', compact('asset')); // Create a new pdf.blade.php view
        return $pdf->download('asset_' . $asset->id . '.pdf');
    }
}
