<!DOCTYPE html>
<html>
<head>
    <title>Holiday Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        .holiday-container {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .holiday-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            text-align: center;
        }

        .holiday-dates {
            font-size: 1em;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .holiday-photo {
            text-align: center;
            margin-bottom: 15px;
        }

        .holiday-photo img {
            max-width: 100%;
            max-height: 300px;
        }

        .holiday-details {
            font-size: 1.1em;
            line-height: 1.6;
            text-align: justify;
        }
    </style>
</head>
<body>
<div class="holiday-container">
    <div class="holiday-dates">
        <span>{{ \Carbon\Carbon::parse($holiday->from_date)->format('d M Y') }}</span>
        <span>{{ \Carbon\Carbon::parse($holiday->to_date)->format('d M Y') }}</span>
    </div>

    <div class="holiday-photo">
        @if($holiday->photo)
            <img src="{{ public_path('uploads/holidays/' . $holiday->photo) }}" alt="Holiday Photo">
        @else
            No Photo Available
        @endif
    </div>

    <div class="holiday-title">
        {{ $holiday->title }}
    </div>

    <div class="holiday-details">
        {!! $holiday->details !!}
    </div>
</div>
</body>
</html>
