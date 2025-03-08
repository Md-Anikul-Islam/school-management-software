@foreach($routine as $day)
    <tr>
        <td>{{ $day->day }}</td>
        <td>
            {{ $day->first_period_time }}<br>
            Subject: {{ $day->first_period_subject }}<br>
            Class: {{ $day->first_period_class }}<br>
            Section: {{ $day->first_period_section }}<br>
            Room: {{ $day->first_period_room }}
        </td>
        <td>
            {{ $day->second_period_time }}<br>
            Subject: {{ $day->second_period_subject }}<br>
            Class: {{ $day->second_period_class }}<br>
            Section: {{ $day->second_period_section }}<br>
            Room: {{ $day->second_period_room }}
        </td>
    </tr>
@endforeach
