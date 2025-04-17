<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Details (PDF)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title{
            font-size: 24px;
            font-weight: bold;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f0f0f0;
        }
        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .image-container img {
            max-width: 200px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2 class="title">Sponsor Details</h2>
    </div>
    <div class="image-container">
        @if($sponsor->photo)
            <img src="{{ public_path('uploads/sponsors/' . $sponsor->photo) }}" alt="Sponsor Photo" class="img-fluid rounded-circle">
        @else
            <img src="{{ public_path('placeholder.png') }}" alt="No Photo" class="img-fluid rounded-circle">
        @endif
    </div>
    <table class="details-table">
        <tr>
            <th>Title</th>
            <td>{{ $sponsor->title }}</td>
        </tr>
        <tr>
            <th>Sponsor Person Name</th>
            <td>{{ $sponsor->name }}</td>
        </tr>
        <tr>
            <th>Organization Name</th>
            <td>{{ $sponsor->organization_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $sponsor->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $sponsor->phone }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $sponsor->country }}</td>
        </tr>
        <tr>
            <th>Create Date</th>
            <td>{{ $sponsor->created_at }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $sponsor->address }}</td>
        </tr>
    </table>
</div>
</body>
</html>
