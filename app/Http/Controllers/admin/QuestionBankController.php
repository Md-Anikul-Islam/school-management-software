<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\QuestionBank;
use App\Models\QuestionGroup;
use App\Models\QuestionLevel;

class QuestionBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('question-bank-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $pageTitle = 'Question Bank List';
        if(auth()->user()->hasRole('Super Admin')) {
            $questionBanks = QuestionBank::all();
        } else {
            $questionBanks = QuestionBank::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.questionBank.index', compact('pageTitle', 'questionBanks'));
    }

    public function create()
    {
        if (!Gate::allows('question-bank-create')) {
            return redirect()->route('unauthorized.action');
        }
        if(auth()->user()->hasRole('Super Admin')) {
            $questionGroups = QuestionGroup::all();
            $questionLevels = QuestionLevel::all();
        } else {
            $questionGroups = QuestionGroup::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $questionLevels = QuestionLevel::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.questionBank.add', compact('questionGroups', 'questionLevels'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'question_group_id' => 'required',
                'question_level_id' => 'required',
                'question' => 'required',
                'question_type' => 'required',
                'total_options' => 'nullable|integer|min:0', // Optional, integer, non-negative
                // Add validation for correct_answers here if needed
            ]);

            $questionBank = new QuestionBank();

            // File Upload Handling
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/question_bank/', $fileName);
                $questionBank->upload = $fileName;
            }

            $questionBank->question_group_id = $request->question_group_id;
            $questionBank->question_level_id = $request->question_level_id;
            $questionBank->question = $request->question;
            $questionBank->explanation = $request->explanation;
            $questionBank->hints = $request->hints;
            $questionBank->mark = $request->mark;
            $questionBank->question_type = $request->question_type;

            // Options Handling
            if ($request->filled('total_options') && $request->total_options > 0) {
                $options = [];
                for ($i = 1; $i <= $request->total_options; $i++) {
                    $optionKey = 'option_' . $i;
                    if ($request->filled($optionKey)) {
                        $options[] = $request->$optionKey;
                    }
                }
                $questionBank->options = json_encode($options);
            }

            // Correct Answers Handling
            if ($request->question_type === 'Multi Answer' || $request->question_type === 'Single Answer') {
                // Assuming you have a way to identify correct options (e.g., checkboxes)
                $correctAnswers = [];
                for ($i = 1; $i <= $request->total_options; $i++) {
                    if ($request->has('correct_option_' . $i)) {
                        $correctAnswers[] = $request->input('option_' . $i);
                    }
                }
                $questionBank->correct_answers = json_encode($correctAnswers);
            } elseif ($request->question_type === 'Fill in the blanks') {
                // Assuming you have input fields for correct answers
                $correctAnswers = [];
                if ($request->filled('blanks')) {
                    foreach ($request->blanks as $blank) {
                        $correctAnswers[] = $blank;
                    }
                }
                $questionBank->correct_answers = json_encode($correctAnswers);
            }

            $questionBank->school_id = Auth::id(); // Simplified user ID handling
            $questionBank->created_by = Auth::id();
            $questionBank->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $questionBank = QuestionBank::find($id);
        return view('admin.pages.questionBank.show', compact('questionBank'));
    }

    public function edit($id)
    {
        if (!Gate::allows('question-bank-edit')) {
            return redirect()->route('unauthorized.action');
        }
        $questionBank = QuestionBank::find($id);
        if(auth()->user()->hasRole('Super Admin')) {
            $questionGroups = QuestionGroup::all();
            $questionLevels = QuestionLevel::all();
        } else {
            $questionGroups = QuestionGroup::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
            $questionLevels = QuestionLevel::where('school_id', Auth::user()->school_id)->orWhere('school_id', Auth::id())->get();
        }
        return view('admin.pages.questionBank.edit', compact('questionBank', 'questionGroups', 'questionLevels'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'question_group_id' => 'required',
                'question_level_id' => 'required',
                'question' => 'required',
                'question_type' => 'required',
                'total_options' => 'nullable|integer|min:0', // Optional, integer, non-negative
                // Add validation for correct_answers here if needed
            ]);

            $questionBank = QuestionBank::find($id);

            // File Upload Handling
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/question_bank/', $fileName);

                // Delete old file if exists
                if ($questionBank->upload && file_exists(public_path('uploads/question_bank/' . $questionBank->upload))) {
                    unlink(public_path('uploads/question_bank/' . $questionBank->upload));
                }

                $questionBank->upload = $fileName;
            }

            $questionBank->question_group_id = $request->question_group_id;
            $questionBank->question_level_id = $request->question_level_id;
            $questionBank->question = $request->question;
            $questionBank->explanation = $request->explanation;
            $questionBank->hints = $request->hints;
            $questionBank->mark = $request->mark;
            $questionBank->question_type = $request->question_type;

            // Options Handling
            if ($request->filled('total_options') && $request->total_options > 0) {
                $options = [];
                for ($i = 1; $i <= $request->total_options; $i++) {
                    $optionKey = 'option_' . $i;
                    if ($request->filled($optionKey)) {
                        $options[] = $request->$optionKey;
                    }
                }
                $questionBank->options = json_encode($options);
            } else {
                $questionBank->options = null;
            }

            // Correct Answers Handling
            if ($request->question_type === 'Multi Answer' || $request->question_type === 'Single Answer') {
                // Assuming you have a way to identify correct options (e.g., checkboxes)
                $correctAnswers = [];
                for ($i = 1; $i <= $request->total_options; $i++) {
                    if ($request->has('correct_option_' . $i)) {
                        $correctAnswers[] = $request->input('option_' . $i);
                    }
                }
                $questionBank->correct_answers = json_encode($correctAnswers);
            } elseif ($request->question_type === 'Fill in the blanks') {
                // Assuming you have input fields for correct answers
                $correctAnswers = [];
                if ($request->filled('blanks')) {
                    foreach ($request->blanks as $blank) {
                        $correctAnswers[] = $blank;
                    }
                }
                $questionBank->correct_answers = json_encode($correctAnswers);
            }

            $questionBank->school_id = Auth::id(); // Simplified user ID handling
            $questionBank->updated_by = Auth::id();
            $questionBank->save();

            toastr()->success('Data has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $questionBank = QuestionBank::find($id);
            $questionBank->delete();
            toastr()->success('Data has been deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), ['title' => 'Error']);
            return redirect()->back();
        }
    }
}
