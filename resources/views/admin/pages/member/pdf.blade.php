<!DOCTYPE html>
<html>
<head>
    <title>Library Member Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #1a237e;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 10px auto;
            border: 3px solid #90caf9;
        }

        .name {
            font-size: 20px;
            font-weight: bold;
            color: #1a237e;
            margin-bottom: 5px;
        }

        .student-info {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .details-section {
            margin-top: 30px;
        }

        .details-section h2 {
            color: #1a237e;
            margin-bottom: 20px;
            text-align: center;
        }

        .info-block {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: baseline; /* Align items to the baseline */
        }

        .info-block strong {
            color: #1a237e;
            margin-right: 5px; /* Add some space between the label and value */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Library Member Details</h1>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="profile-card">
                <div class="profile-avatar">
                    @if($libraryMember->student->photo)
                        <img src="{{ public_path('uploads/students/' . $libraryMember->student->photo) }}"
                             alt="{{ $libraryMember->student->name }}" width="120" class="img-thumbnail">
                    @else
                        <div
                            style="width: 120px; height: 120px; background-color: #f0f0f0; border-radius: 50%; margin: 0 auto 10px;"></div>
                    @endif
                </div>
                <h4 class="name">{{ $libraryMember->student->name }}</h4>
                <p class="student-info">Student</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="details-section">
                <h2>Profile</h2>
                <div class="info-block">
                    <strong>Register NO:</strong>
                    <span>{{ $libraryMember->student->reg_no }}</span>
                </div>
                <div class="info-block">
                    <strong>Roll:</strong>
                    <span>{{ $libraryMember->student->roll }}</span>
                </div>
                <div class="info-block">
                    <strong>Library Name:</strong>
                    <span>{{ $libraryMember->library->title }}</span>
                </div>
                <div class="info-block">
                    <strong>Library Code:</strong>
                    <span>{{ $libraryMember->library->code }}</span>
                </div>
                <div class="info-block">
                    <strong>Library Fee:</strong>
                    <span>{{ $libraryMember->library->fee }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
