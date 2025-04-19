<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('expense-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Expenses';
        if(auth()->user()->hasRole('Super Admin')) {
            $expenses = Expense::all();
        } else {
            $expenses = Expense::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.expenses.index', compact('pageTitle', 'expenses'));
    }

    public function create()
    {
        if (!Gate::allows('expense-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.expenses.add');
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
            $expense = new Expense();
            $expense->name = $request->name;
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $request->file->move(public_path('uploads/expenses/'), $fileName);
                $expense->file = $fileName;
            }
            $expense->note = $request->note;
            $expense->school_id = Auth::user()->school_id ?? Auth::id();
            $expense->created_by = Auth::id();
            $expense->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('expense-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $expense = Expense::find($id);
        return view('admin.pages.expenses.edit', compact('expense'));
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
            $expense = Expense::find($id);
            $expense->name = $request->name;
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            if ($request->hasFile('file')) {
                if ($expense->file) {
                    unlink(public_path('uploads/expenses/' . $expense->file));
                }
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $request->file->move(public_path('uploads/expenses/'), $fileName);
                $expense->file = $fileName;
            }
            $expense->note = $request->note;
            $expense->school_id = Auth::user()->school_id ?? Auth::id();
            $expense->updated_by = Auth::id();
            $expense->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('expense-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $expense = Expense::find($id);
            if ($expense->file) {
                unlink(public_path('uploads/expenses/' . $expense->file));
            }
            $expense->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        }catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
