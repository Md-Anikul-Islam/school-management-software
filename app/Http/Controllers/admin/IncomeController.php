<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('income-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Incomes';
        if(auth()->user()->hasRole('Super Admin')) {
            $incomes = Income::all();
        } else {
            $incomes = Income::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.incomes.index', compact('pageTitle', 'incomes'));
    }

    public function create()
    {
        if (!Gate::allows('income-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.incomes.add');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required|date',
                'amount' => 'required|numeric',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'note' => 'nullable|string|max:255',
            ]);
            $income = new Income();
            $income->name = $request->name;
            $income->date = $request->date;
            $income->amount = $request->amount;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $request->file->move(public_path('uploads/incomes/'), $fileName);
                $income->file = $fileName;
            }
            $income->note = $request->note;
            $income->school_id = Auth::user()->school_id ?? Auth::id();
            $income->created_by = Auth::id();
            $income->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('income-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $income = Income::find($id);
        return view('admin.pages.incomes.edit', compact('income'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'date' => 'required|date',
                'amount' => 'required|numeric',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'note' => 'nullable|string|max:255',
            ]);
            $income = Income::find($id);
            $income->name = $request->name;
            $income->date = $request->date;
            $income->amount = $request->amount;
            if ($request->hasFile('file')) {
                if ($income->file) {
                    unlink(public_path('uploads/incomes/' . $income->file));
                }
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $request->file->move(public_path('uploads/incomes/'), $fileName);
                $income->file = $fileName;
            }
            $income->note = $request->note;
            $income->school_id = Auth::user()->school_id ?? Auth::id();
            $income->updated_by = Auth::id();
            $income->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('income-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $income = Income::find($id);
            if ($income->file) {
                unlink(public_path('uploads/incomes/' . $income->file));
            }
            $income->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
