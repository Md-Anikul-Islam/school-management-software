<!DOCTYPE html>
<html>
<head>
    <title>Transport Member Details</title>
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
<h1>Transport Member Details</h1>

<table>
    <tr>
        <th>Student Name</th>
        <td>{{ $transportMember->student->name }}</td>
    </tr>
    <tr>
        <th>Student Roll</th>
        <td>{{ $transportMember->student->roll }}</td>
    </tr>
    <tr>
        <th>Route Name</th>
        <td>{{ $transportMember->transport->route_name }}</td>
    </tr>
    <tr>
        <th>Route Fare</th>
        <td>{{ $transportMember->fare }}</td>
    </tr>
    <tr>
        <th>Vehicle Number</th>
        <td>{{ $transportMember->transport->vehicle_no }}</td>
    </tr>
</table>
</body>
</html>
