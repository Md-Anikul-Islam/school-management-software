<!DOCTYPE html>
<html>
<head>
    <title>Leave Application Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .leave-details {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        .leave-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .leave-details table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .leave-details table td:first-child {
            font-weight: bold;
            width: 30%;
        }

        .leave-details p {
            margin-top: 20px;
            white-space: pre-line;
        }
    </style>
</head>
<body>
<div class="leave-details">
    <table>
        <tr>
            <td>Name</td>
            <td>: {{ $leaveApply->applicationTo->name }}</td>
        </tr>
        <tr>
            <td>Type</td>
            <td>:
                @if($leaveApply->role_id == 1)
                    Student
                @else
                    Teacher
                @endif
            </td>
        </tr>
        <tr>
            <td>Register NO</td>
            <td>: 1</td>
        </tr>
        <tr>
            <td>Roll</td>
            <td>: 1</td>
        </tr>
        <tr>
            <td>Class</td>
            <td>: Two</td>
        </tr>
        <tr>
            <td>Section</td>
            <td>: A</td>
        </tr>
        <tr>
            <td>Create Date</td>
            <td>: {{ $leaveApply->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Schedule</td>
            <td>: {{ $leaveApply->start_date }} - {{ $leaveApply->end_date }}</td>
        </tr>
        <tr>
            <td>Leave Day</td>
            <td>: 2</td>
        </tr>
        <tr>
            <td>Holiday</td>
            <td>: 0</td>
        </tr>
        <tr>
            <td>Weekend Day</td>
            <td>: 0</td>
        </tr>
        <tr>
            <td>Total Day</td>
            <td>: 2</td>
        </tr>
        <tr>
            <td>Category</td>
            <td>: {{ $leaveApply->leaveCategory->category }}</td>
        </tr>
        <tr>
            <td>Application Status</td>
            <td>: {{ $leaveApply->status }}</td>
        </tr>
    </table>
    <div style="margin-top: 10px; margin-left: 7px;">
        <strong>Reason:</strong>
        <p>{!! $leaveApply->reason !!}</p>
    </div>
</div>
</body>
</html>
