<!DOCTYPE html>
<html>
<head>
    <title>Event Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        .event-container {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .event-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            text-align: center;
        }

        .event-dates {
            font-size: 1em;
            margin-bottom: 15px;
            text-align: left;
        }

        .event-photo {
            text-align: center;
            margin-bottom: 15px;
        }

        .event-photo img {
            max-width: 300px;
            max-height: 300px;
        }

        .event-details {
            font-size: 1.1em;
            line-height: 1.6;
            text-align: justify;
        }

        .event-author {
            margin-top: 30px;
            text-align: right; /* Align to the right */
        }

        .event-author strong {
            display: block;
        }
    </style>
</head>
<body>
<div class="event-container">
    <div class="event-dates">
        From: {{ $event->from_date }} <br>
        To: {{ $event->to_date }}
    </div>

    <div class="event-title">
        {{ $event->title }}
    </div>

    <div class="event-photo">
        @if($event->photo)
            <img src="{{ public_path('uploads/events/' . $event->photo) }}" alt="Event Photo">
        @else
            No Photo Available
        @endif
    </div>

    <div class="event-details">
        {!! $event->details !!}
    </div>

    <div class="event-author">
        <strong>{{ $createdBy->name }}</strong>
        ({{ $createdBy->role }}, {{ $createdBy->school->name ?? 'iNiLabs School' }})
    </div>
</div>
</body>
</html>
