@extends('admin.app')
@section('admin_content')
    <style>
        .profile-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .profile-card h4 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #1a237e;
        }

        .profile-avatar {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #90caf9;
        }

        .profile-info {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-info strong {
            color: #1a237e;
        }

        .profile-details {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Library Member Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Library Member Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('library-member-list')
                        <a href="{{ route('library-members.index') }}" class="btn btn-primary"><span><i
                                    class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                    <a href="{{ route('library-members.pdf', $libraryMember->id) }}" class="btn btn-success">Download PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-card h-100">
                            <div class="profile-avatar">
                                <img src="{{ $libraryMember->student->photo ? asset('uploads/students/' . $libraryMember->student->photo) : asset('assets/images/users/avatar-1.jpg') }}" alt="Profile Picture">
                            </div>
                            <h4>{{ $libraryMember->student->name }}</h4>
                            <p>Student</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="profile-details h-100">
                            <h4>Profile</h4>
                            <div class="profile-info">
                                <strong>Register NO:</strong>
                                <span>{{ $libraryMember->student->reg_no }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Roll:</strong>
                                <span>{{ $libraryMember->student->roll }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Library Name:</strong>
                                <span>{{ $libraryMember->library->title }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Library Code:</strong>
                                <span>{{ $libraryMember->library->code }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Library Fee:</strong>
                                <span>{{ $libraryMember->library->fee }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
