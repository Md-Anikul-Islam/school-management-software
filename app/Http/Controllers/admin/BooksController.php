<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('books-list',)) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Books';
        if(auth()->user()->can('Super Admin')) {
            $books = Books::all();
        } else {
            $books = Books::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.books.index', compact('books', 'pageTitle'));
    }

    public function create()
    {
        if(!Gate::allows('books-create')) {
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.books.add');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'author' => 'required',
                'subject_code' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'rack_no' => 'required',
            ]);
            $book = new Books();
            $book->name = $request->name;
            $book->author = $request->author;
            $book->subject_code = $request->subject_code;
            $book->price = $request->price;
            $book->quantity = $request->quantity;
            $book->rack_no = $request->rack_no;
            $book->status = 1;
            $book->school_id = Auth::user()->school_id ?? Auth::id();
            $book->created_by = Auth::id();
            $book->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!Gate::allows('books-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $book = Books::find($id);
        return view('admin.pages.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'author' => 'required',
                'subject_code' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'rack_no' => 'required',
            ]);
            $book = Books::find($id);
            $book->name = $request->name;
            $book->author = $request->author;
            $book->subject_code = $request->subject_code;
            $book->price = $request->price;
            $book->quantity = $request->quantity;
            $book->rack_no = $request->rack_no;
            $book->status = $request->status ? 1 : 0;
            $book->school_id = Auth::user()->school_id ?? Auth::id();
            $book->updated_by = Auth::id();
            $book->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(!Gate::allows('books-delete')) {
            return redirect()->route('unauthorized.action');
        }
        try{
            $book = Books::find($id);
            $book->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

}
