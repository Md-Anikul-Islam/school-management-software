<!DOCTYPE html>
<html>
<head>
    <title>Question Bank Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

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
            text-align: right;
        }

        .option {
            margin-bottom: 10px;
        }

        .option label {
            margin-left: 5px;
        }

        .option input[type="radio"],
        .option input[type="checkbox"] {
            vertical-align: middle;
        }

        .blank-option {
            margin-bottom: 10px;
        }

        .blank-option input[type="text"] {
            display: inline-block;
            width: 150px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<div class="question-container">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="question-text">
            @if($questionBank->question_type === 'Fill in the blanks' && $questionBank->correct_answers)
                {!! $questionBank->question !!} _____
                @php
                    $correctAnswers = json_decode($questionBank->correct_answers);
                @endphp
                @if(is_array($correctAnswers) && count($correctAnswers) > 0)
                    <div style="margin-top: 5px;">
                        Answer: {{ $correctAnswers[0] ?? 'N/A' }}
                    </div>
                @else
                    <div style="margin-top: 5px;">
                        Answer: N/A
                    </div>
                @endif
            @else
                {!! $questionBank->question !!}
            @endif
        </div>
        <div class="question-mark">
            {{ $questionBank->mark }} Mark
        </div>
    </div>

    @if ($questionBank->question_type === 'Single Answer' && $questionBank->options)
        <form>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                @php
                    $correctAnswers = json_decode($questionBank->correct_answers);
                @endphp
                @foreach (json_decode($questionBank->options) as $key => $option)
                    <div class="option">
                        <input type="radio" id="option{{ $key }}" name="answer" value="{{ $option }}" {{ isset($correctAnswers[0]) && $correctAnswers[0] == $key ? 'checked' : '' }}>
                        <label for="option{{ $key }}">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
        </form>
    @elseif ($questionBank->question_type === 'Multi Answer' && $questionBank->options)
        <form>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                @php
                    $correctAnswers = json_decode($questionBank->correct_answers);
                @endphp
                @foreach (json_decode($questionBank->options) as $key => $option)
                    <div class="option">
                        <input type="checkbox" id="option{{ $key }}" name="answers[]" value="{{ $option }}" {{ in_array($key, $correctAnswers ?? []) ? 'checked' : '' }}>
                        <label for="option{{ $key }}">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
        </form>
    @endif
</div>
</body>
</html>
