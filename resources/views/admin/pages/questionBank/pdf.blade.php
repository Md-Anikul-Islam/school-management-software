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

        .option input[type="radio"] {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="question-container">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="question-text">
            {!! $questionBank->question !!}
        </div>
        <div class="question-mark">
            {{ $questionBank->mark }} Mark
        </div>
    </div>

    @if ($questionBank->question_type === 'Single Answer' && $questionBank->options)
        <form>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                @foreach (json_decode($questionBank->options) as $key => $option)
                    <div class="option">
                        <input type="radio" id="option{{ $key }}" name="answer" value="{{ $option }}" {{ $key === 2 ? 'checked' : '' }}>
                        <label for="option{{ $key }}">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
        </form>
    @elseif ($questionBank->question_type === 'Multi Answer' && $questionBank->options)
        <form>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                @foreach (json_decode($questionBank->options) as $key => $option)
                    <div class="option">
                        <input type="checkbox" id="option{{ $key }}" name="answers[]" value="{{ $option }}">
                        <label for="option{{ $key }}">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
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
</body>
</html>
