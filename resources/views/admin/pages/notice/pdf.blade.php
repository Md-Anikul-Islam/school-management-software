<!DOCTYPE html>
<html>
<head>
    <title>Notice Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        .notice-container {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .notice-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            text-align: center;
        }

        .notice-date {
            font-size: 1em;
            margin-bottom: 15px;
            text-align: left;
        }

        .notice-content {
            font-size: 1.1em;
            line-height: 1.6;
            text-align: justify;
        }

        .notice-author {
            margin-top: 30px;
            text-align: right; /* Align to the right */
        }

        .notice-author strong {
            display: block;
        }
    </style>
</head>
<body>
<div class="notice-container">
    <div class="notice-date">
        Date: {{ $notice->date }}
    </div>

    <div class="notice-title">
        {{ $notice->title }}
    </div>

    <div class="notice-content">
        {!! $notice->notice !!}
    </div>

    <div class="notice-author">
        <strong>{{ $createdBy->name }}</strong>
        ({{ $createdBy->role }}, {{ $createdBy->school->name ?? 'iNiLabs School' }})
    </div>
</div>
</body>
</html>
