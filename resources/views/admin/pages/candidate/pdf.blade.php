<!DOCTYPE html>
<html>
<head>
    <title>Candidate Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        <h1>Candidate Details</h1>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="profile-card">
                <div class="profile-avatar">
                    @if($candidate->student->photo)
                        <img src="{{ public_path('uploads/students/' . $candidate->student->photo) }}"
                             alt="{{ $candidate->student->name }}"  width="120" class="img-thumbnail">
                    @else
                        <div
                            style="width: 120px; height: 120px; background-color: #f0f0f0; border-radius: 50%; margin: 0 auto 10px;"></div>
                    @endif
                </div>
                <h4 class="name">{{ $candidate->student->name }}</h4>
                <p class="student-info">Student</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="details-section">
                <h2>Profile</h2>
                <div class="info-block">
                    <strong>Register NO:</strong>
                    <span>{{ $candidate->student_registration_number }}</span>
                </div>
                <div class="info-block">
                    <strong>Roll:</strong>
                    <span>{{ $candidate->student->roll }}</span>
                </div>
                <div class="info-block">
                    <strong>Class:</strong>
                    <span>{{ $candidate->class->name }}</span>
                </div>
                <div class="info-block">
                    <strong>Section:</strong>
                    <span>{{ $candidate->section->name }}</span>
                </div>
                <div class="info-block">
                    <strong>Religion:</strong>
                    <span>{{ $candidate->student->religion }}</span>
                </div>
                <div class="info-block">
                    <strong>Application Verified By:</strong>
                    <span>{{ $candidate->application_verified_by }}</span>
                </div>
                <div class="info-block">
                    <strong>Date of Verification:</strong>
                    <span>{{ $candidate->date_of_verification }}</span>
                </div>
                <div class="info-block">
                    <strong>Email:</strong>
                    <span>{{ $candidate->student->email }}</span>
                </div>
                <div class="info-block">
                    <strong>Phone:</strong>
                    <span>{{ $candidate->student->phone }}</span>
                </div>
                <div class="info-block">
                    <strong>Address:</strong>
                    <span>{{ $candidate->student->address }}</span>
                </div>
                <div class="info-block">
                    <strong>Username:</strong>
                    <span>{{ $candidate->student->username }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
