<!DOCTYPE html>
<html>
<head>
    <title>Asset Assignment Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .info-table th {
            width: 25%;
            font-weight: bold;
        }
        .info-table td {
            width: 75%;
        }
        .info-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .info-table tr:first-child th {
            border-top: none;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .info-table tr td:first-child {
            border-left: none;
        }
        .info-table tr td:last-child {
            border-right: none;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Asset Assignment Infomation :</h1>
    <table class="info-table">
{{--        <tr>--}}
{{--            <th>Role</th>--}}
{{--            <td>{{ $assetAssignment->role->name }}</td>--}}
{{--        </tr>--}}
        <tr>
            <th>Asset</th>
            <td>{{ $assetAssignment->asset->title }}</td>
        </tr>
        <tr>
            <th>Assign Quantity</th>
            <td>{{ $assetAssignment->assign_quantity }}</td>
        </tr>
        <tr>
            <th>Due Date</th>
            <td>{{ $assetAssignment->due_date }}</td>
        </tr>
        <tr>
            <th>Check Out Date</th>
            <td>{{ $assetAssignment->check_out_date }}</td>
        </tr>
        <tr>
            <th>Check In Date</th>
            <td>{{ $assetAssignment->check_in_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $assetAssignment->status }}</td>
        </tr>
        <tr>
            <th>Note</th>
            <td>{{ $assetAssignment->note }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $assetAssignment->location->location }}</td>
        </tr>
    </table>
</div>
</body>
</html>
