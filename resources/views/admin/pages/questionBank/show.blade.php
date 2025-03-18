@extends('admin.app')
@section('admin_content')
    <style>
        .question-container {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .question-text {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .question-mark {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .option, .blank-option {
            margin-bottom: 10px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">View Question Bank</li>
                    </ol>
                </div>
                <h4 class="page-title">View Question Bank</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('question-bank.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                        <a href="{{ route('question-bank.download.pdf', $questionBank->id) }}" class="btn btn-success">Download PDF</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="question-container">
                    <div class="d-flex justify-content-between">
                        <div class="question-text">
                            {!! $questionBank->question !!}
                        </div>

                        <div class="question-mark">
                            {{ $questionBank->mark }} Mark
                        </div>
                    </div>


                    @if ($questionBank->question_type === 'Single Answer' && $questionBank->options)
                        <form>
                            @foreach (json_decode($questionBank->options) as $key => $option)
                                <div class="option">
                                    <input type="radio" id="option{{ $key }}" name="answer" value="{{ $option }}">
                                    <label for="option{{ $key }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        </form>
                    @elseif ($questionBank->question_type === 'Multi Answer' && $questionBank->options)
                        <form>
                            @foreach (json_decode($questionBank->options) as $key => $option)
                                <div class="option">
                                    <input type="checkbox" id="option{{ $key }}" name="answers[]" value="{{ $option }}">
                                    <label for="option{{ $key }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        </form>
                    @elseif ($questionBank->question_type === 'Fill in the blanks' && $questionBank->options)
                        <form>
                            @foreach (json_decode($questionBank->options) as $key => $option)
                                <div class="blank-option">
                                    <label for="blank{{ $key }}">{{ $key + 1 }}.</label>
                                    <input type="text" id="blank{{ $key }}" name="blanks[]" placeholder="Enter Answer">
                                </div>
                            @endforeach
                        </form>
                    @else
                        <p>This question type does not have options or is not supported.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
