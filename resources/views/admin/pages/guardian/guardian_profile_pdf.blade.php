<!DOCTYPE html>
<html>
<head>
    <title>Guardian Profile - {{ $guardian->name }}</title>
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
        @if($guardian->photo)
            <img src="{{ public_path('uploads/guardians/' . $guardian->photo) }}" alt="{{ $guardian->name }}" class="profile-image">
        @else
            <div style="width: 150px; height: 150px; background-color: #f0f0f0; border-radius: 50%; margin: 0 auto 10px;"></div>
        @endif
        <h2>{{ $guardian->name }}</h2>
    </div>
    <div class="profile-details">
        <table>
            <tr>
                <td>Father's Name</td>
                <td>{{ $guardian->father_name }}</td>
            </tr>
            <tr>
                <td>Mother's Name</td>
                <td>{{ $guardian->mother_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $guardian->email }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{ $guardian->address }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>Father's Profession</td>
                <td>{{ $guardian->father_profession }}</td>
            </tr>
            <tr>
                <td>Mother's Profession</td>
                <td>{{ $guardian->mother_profession }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{ $guardian->phone }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
