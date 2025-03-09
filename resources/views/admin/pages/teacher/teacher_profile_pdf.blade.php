<!DOCTYPE html>
<html>
<head>
    <title>Teacher Profile - {{ $teacher->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .profile-container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .profile-details {
            display: flex;
            justify-content: space-between;
        }
        .profile-details table {
            width: 48%; /* Adjust width for better spacing */
            border-collapse: collapse; /* Remove extra spacing in tables */
        }
        .profile-details table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            text-align: left; /* Align text to the left */
        }
        .profile-details table td:first-child {
            font-weight: bold;
            width: 120px; /* Set a fixed width for the first column */
        }
        .profile-details table td:nth-child(2) {
            width: auto; /* Allow the second column to take remaining space */
        }
    </style>
</head>
<body>
<div class="profile-container">
    <div class="profile-header">
        @if($teacher->photo)
            <img src="{{ public_path('uploads/teachers/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="profile-image">
        @else
            <div style="width: 150px; height: 150px; background-color: #f0f0f0; border-radius: 50%; margin: 0 auto 10px;"></div>
        @endif
        <h2>{{ $teacher->name }}</h2>
        <p>{{ $teacher->designation }}</p>
    </div>
    <div class="profile-details">
        <table>
            <tr>
                <td>Joining Date</td>
                <td>{{ $teacher->joining_date }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $teacher->email }}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>{{ $teacher->gender }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>Religion</td>
                <td>{{ $teacher->religion }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{ $teacher->address }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{ $teacher->phone }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
