@extends('admin.app')
@section('admin_content')

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px; /* Same as Bootstrap .form-control */
            border: 1px solid #ced4da; /* Same as Bootstrap input border */
            border-radius: 5px; /* Rounded corners */
            padding: 6px 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px; /* Align text properly */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px; /* Align arrow with input */
        }

        .readonly-select {
            pointer-events: none;
            background-color: #e9ecef; /* Light gray to show it's disabled */
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Question Bank</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Question Bank</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('question-bank-list')
                        <a href="{{ route('question-bank.index') }}" class="btn btn-primary"><span><i
                                    class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('question-bank.update', $questionBank->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="question_group_id" class="form-label">Question Group</label>
                        <select class="form-control readonly-select" id="question_group_id" name="question_group_id" required>
                            <option value="">Select Question Group</option>
                            @foreach($questionGroups as $group)
                                <option
                                    value="{{ $group->id }}" {{ $questionBank->question_group_id == $group->id ? 'selected' : '' }}>{{ $group->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="question_level_id" class="form-label">Difficulty Level</label>
                        <select class="form-control readonly-select" id="question_level_id" name="question_level_id" required>
                            <option value="">Select Difficulty Level</option>
                            @foreach($questionLevels as $level)
                                <option
                                    value="{{ $level->id }}" {{ $questionBank->question_level_id == $level->id ? 'selected' : '' }}>{{ $level->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" id="question_{{$editorId}}" name="question" rows="3"
                                  >{!! $questionBank->question !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="explanation" class="form-label">Explanation</label>
                        <textarea class="form-control" id="explanation_{{$editorId}}" name="explanation"
                                  rows="3">{!! $questionBank->explanation !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="upload" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="upload" name="upload" readonly>
                        @if($questionBank->upload)
                            <a href="{{ asset('uploads/question_bank/' . $questionBank->upload) }}"
                               class="btn btn-success mt-2" download>
                                <i class="ri-download-line"></i> Download Current File
                            </a>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="hints" class="form-label">Hints</label>
                        <textarea class="form-control" id="hints" name="hints"
                                  rows="3">{{ $questionBank->hints }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mark" class="form-label">Mark</label>
                        <input type="number" class="form-control" id="mark" name="mark"
                               value="{{ $questionBank->mark }}">
                    </div>
                    <div class="mb-3">
                        <label for="question_type" class="form-label">Question Type</label>
                        <select class="form-control readonly-select" id="question_type" name="question_type" required>
                            <option value="">Select Question Type</option>
                            <option
                                value="Single Answer" {{ $questionBank->question_type == 'Single Answer' ? 'selected' : '' }}>
                                Single Answer
                            </option>
                            <option
                                value="Multi Answer" {{ $questionBank->question_type == 'Multi Answer' ? 'selected' : '' }}>
                                Multi Answer
                            </option>
                            <option
                                value="Fill in the blanks" {{ $questionBank->question_type == 'Fill in the blanks' ? 'selected' : '' }}>
                                Fill in the blanks
                            </option>
                        </select>
                    </div>
                    <div class="mb-3" id="total_options_div"
                         style="{{ ($questionBank->question_type == 'Single Answer' || $questionBank->question_type == 'Multi Answer') ? 'display: block;' : 'display: none;' }}">
                        <label for="total_options" class="form-label">Total Options</label>
                        <input type="number" class="form-control" id="total_options" name="total_options" min="0"
                               max="10"
                               value="{{ $questionBank->options ? count(json_decode($questionBank->options)) : 0 }}" readonly>
                    </div>
                    <div id="options_container">
                        @if ($questionBank->options && ($questionBank->question_type == 'Single Answer' || $questionBank->question_type == 'Multi Answer'))
                            @php
                                $correctAnswers = json_decode($questionBank->correct_answers) ?? [];
                                $options = json_decode($questionBank->options) ?? [];
                            @endphp
                            @foreach ($options as $key => $option)
                                <div class="mb-3">
                                    <label for="option_{{ $key + 1 }}" class="form-label">Option {{ $key + 1 }}</label>
                                    @if ($questionBank->question_type == 'Single Answer')
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="correct_answer"
                                                   id="correct_option_{{ $key + 1 }}"
                                                   value="option_{{ $key + 1 }}" {{ in_array($key, $correctAnswers) ? 'checked' : '' }}>
                                            <input type="text" class="form-control" id="option_{{ $key + 1 }}"
                                                   name="option_{{ $key + 1 }}" value="{{ $option }}">
                                        </div>
                                    @elseif ($questionBank->question_type == 'Multi Answer')
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="correct_answers[]"
                                                   id="correct_option_{{ $key + 1 }}"
                                                   value="option_{{ $key + 1 }}" {{ in_array($key, $correctAnswers) ? 'checked' : '' }}>
                                            <input type="text" class="form-control" id="option_{{ $key + 1 }}"
                                                   name="option_{{ $key + 1 }}" value="{{ $option }}">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @elseif($questionBank->question_type == 'Fill in the blanks')
                            <div id="blanks_container">
                                <label class="form-label">Correct Answers for Blanks</label>
                                <div id="blanks_inputs">
                                    @if($questionBank->correct_answers)
                                        @foreach(json_decode($questionBank->correct_answers) as $blank)
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="blanks[]" placeholder="Correct Answer" value="{{ $blank }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="blanks[]" placeholder="Correct Answer">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            if (typeof $.fn.select2 !== "undefined") {
                $('.select2').select2();
            } else {
                console.error("Select2 not loaded");
            }
        });
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#question_{{$editorId}}'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#explanation_{{$editorId}}'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questionTypeSelect = document.getElementById('question_type_{{$editorId}}');
            const totalOptionsDiv = document.getElementById('total_options_div_{{$editorId}}');
            const totalOptionsInput = document.getElementById('total_options_{{$editorId}}');
            const optionsContainer = document.getElementById('options_container_{{$editorId}}');
            const blanksContainer = document.getElementById('blanks_container_{{$editorId}}');

            // Handle Question Type Changes
            questionTypeSelect.addEventListener('change', function () {
                if (this.value === 'Single Answer' || this.value === 'Multi Answer') {
                    totalOptionsDiv.style.display = 'block';
                    blanksContainer.style.display = 'none';
                    optionsContainer.innerHTML = '';
                } else if (this.value === 'Fill in the blanks') {
                    totalOptionsDiv.style.display = 'none';
                    blanksContainer.style.display = 'block';
                    optionsContainer.innerHTML = '';
                } else {
                    totalOptionsDiv.style.display = 'none';
                    blanksContainer.style.display = 'none';
                    optionsContainer.innerHTML = '';
                }
            });

            // Generate Options Dynamically
            totalOptionsInput.addEventListener('input', function () {
                const totalOptions = parseInt(this.value, 10);
                optionsContainer.innerHTML = '';
                for (let i = 1; i <= totalOptions; i++) {
                    const optionInput = document.createElement('div');
                    optionInput.classList.add('mb-3');
                    if (questionTypeSelect.value === 'Single Answer') {
                        optionInput.innerHTML = `
                        <label for="option_${i}_{{$editorId}}" class="form-label">Option ${i}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="correct_answer_{{$editorId}}"
                                   id="correct_option_${i}_{{$editorId}}" value="option_${i}" />
                            <input type="text" class="form-control" id="option_${i}_{{$editorId}}" name="option_${i}" />
                        </div>`;
                    } else if (questionTypeSelect.value === 'Multi Answer') {
                        optionInput.innerHTML = `
                        <label for="option_${i}_{{$editorId}}" class="form-label">Option ${i}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="correct_answers_{{$editorId}}[]"
                                   id="correct_option_${i}_{{$editorId}}" value="option_${i}" />
                            <input type="text" class="form-control" id="option_${i}_{{$editorId}}" name="option_${i}" />
                        </div>`;
                    }
                    optionsContainer.appendChild(optionInput);
                }
            });

            // Trigger Input Event if Options Exist
            if (totalOptionsInput.value) {
                totalOptionsInput.dispatchEvent(new Event('input'));
            }
        });
    </script>

@endsection
