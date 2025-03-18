<!DOCTYPE html>
<html>
<head>
    <title>Asset Details</title>
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
    <h1>Asset Information :</h1>
    <table class="info-table">
        <tr>
            <th>Serial</th>
            <td>{{ $asset->serial }}</td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $asset->title }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $asset->status }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $asset->assetCategory->category }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $asset->location->location }}</td>
        </tr>
        <tr>
            <th>Condition</th>
            <td>{{ $asset->condition }}</td>
        </tr>
        <tr>
            <th>Create Date</th>
            <td>{{ $asset->created_at->format('d M Y') }}</td>
        </tr>
    </table>
</div>
</body>
</html>
