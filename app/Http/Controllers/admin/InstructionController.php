<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Instruction;

class InstructionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('instruction-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $instructions = Instruction::all();
        } else {
            $instructions = Instruction::where('school_id', Auth()->user()->school_id)->orWhere('school_id', Auth::id()->school_id)->get();
        }
        return view('admin.pages.instruction.index', compact('instructions'));
    }

    public function create()
    {
        if(!Gate::allows('instruction-create')){
            return redirect()->route('unauthorized.action');
        }
        return view('admin.pages.instruction.add');
    }

    public function store(Request $request){
        try{
            $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);
            $instruction = new Instruction();
            $instruction->title = $request->title;
            $instruction->content = $request->content;
            $instruction->school_id = Auth()->user()->school_id ?? Auth()->id();
            $instruction->created_by = Auth()->id();
            $instruction->save();
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function edit($id){
        if(!Gate::allows('instruction-edit')){
            return redirect()->route('unauthorized.action');
        }
        $instruction = Instruction::find($id);
        $key = (int) $id;
        return view('admin.pages.instruction.edit', compact('instruction', 'key'));
    }

    public function update(Request $request, $id){
        try{
            $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);
            $instruction = Instruction::find($id);
            $instruction->title = $request->title;
            $instruction->content = $request->content;
            $instruction->school_id = Auth()->user()->school_id ?? Auth()->id();
            $instruction->updated_by = Auth()->id();
            $instruction->save();
            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e){
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id){
        if(!Gate::allows('instruction-show')){
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')){
            $instruction = Instruction::find($id);
        } else {
            $instruction = Instruction::where('school_id', Auth()->user()->school_id)->orWhere('school_id', Auth::id()->school_id)->find($id);
        }
        return view('admin.pages.instruction.show', compact('instruction'));
    }

    public function destroy($id){
        if(auth()->user()->hasRole('Super Admin')){
            $instruction = Instruction::find($id);
        } else {
            $instruction = Instruction::where('school_id', Auth()->user()->school_id)->orWhere('school_id', Auth::id()->school_id)->find($id);
        }
        $instruction->delete();
        toastr()->success('Data has been deleted successfully!');
        return redirect()->back();
    }
}
