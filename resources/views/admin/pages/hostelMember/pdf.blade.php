<!DOCTYPE html>
<html>
<head>
    <title>Hostel Member Details</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Hostel Member Details</h1>

<table>
    <tr>
        <th>Student Name</th>
        <td>{{ $hostelMember->student->name }}</td>
    </tr>
    <tr>
        <th>Student Roll</th>
        <td>{{ $hostelMember->student->roll }}</td>
    </tr>
    <tr>
        <th>Hostel Name</th>
        <td>{{ $hostelMember->hostel->name }}</td>
    </tr>
    <tr>
        <th>Hostel Category</th>
        <td>{{ $hostelMember->hostelCategory->class_type }}</td>
    </tr>
    <tr>
        <th>Hostel Fee</th>
        <td>{{ $hostelMember->hostelCategory->hostel_fee }}</td>
    </tr>
    <tr>
        <th>Hostel Address</th>
        <td>{{ $hostelMember->hostel->address }}</td>
    </tr>
    <tr>
        <th>Hostel Type</th>
        <td>{{ $hostelMember->hostel->type }}</td>
    </tr>
</table>
</body>
</html>
