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
            align-items: center; /* Vertically align items */
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
            gap: 10px; /* Add some gap between buttons */
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Candidate Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Candidate Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        @can('library-member-list')
                            <a href="{{ route('candidate.index') }}" class="btn btn-primary"><span><i
                                        class="ri-arrow-go-back-line"></i></span>Back</a>
                        @endcan
                        <a href="{{ route('candidate.pdf', $candidate->id) }}" class="btn btn-success">Download PDF</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-card h-100">
                            <div class="profile-avatar">
                                <img src="{{ $candidate->student->photo ? asset('uploads/students/' . $candidate->student->photo) : asset('assets/images/users/avatar-1.jpg') }}" alt="Profile Picture">
                            </div>
                            <h4>{{ $candidate->student->name }}</h4>
                            <p>Student</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="profile-details h-100">
                            <h4>Profile</h4>
                            <div class="profile-info">
                                <strong>Register NO:</strong>
                                <span>{{ $candidate->student_registration_number }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Class:</strong>
                                <span>{{ $candidate->class_id }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Section:</strong>
                                <span>{{ $candidate->section_id }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Group:</strong>
                                <span>{{ $candidate->student->group ?? 'N/A' }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Optional Subject:</strong>
                                <span>{{ $candidate->student->optionalSubject->name ?? 'N/A' }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Application Verified By:</strong>
                                <span>{{ $candidate->application_verified_by }}</span>
                            </div>
                            <div class="profile-info">
                                <strong>Date of Verification:</strong>
                                <span>{{ $candidate->date_of_verification }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function sendDataToMail() {
            alert('Mail Send Functionality Not Implemented Yet!');
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script>
        function exportTableToPDF(filename, heading) {
            const {jsPDF} = window.jspdf;
            const doc = new jsPDF();

            // Add the heading
            doc.text(heading, doc.internal.pageSize.getWidth() / 2, 20, {align: 'center'}); // Centered heading

            // Define the data for the PDF -  Use আগে variables
            const data = [
                { title: 'Register NO', value: '{{ $candidate->student_registration_number }}' },
                { title: 'Class', value: '{{ $candidate->class_id }}' },
                { title: 'Section', value: '{{ $candidate->section_id }}' },
                { title: 'Group', value: 'NA' },
                { title: 'Optional Subject', value: 'NA' },
                { title: 'Application Verified By', value: '{{ $candidate->application_verified_by }}' },
                { title: 'Date of Verification', value: '{{ $candidate->date_of_verification }}' },
                { title: 'Student Name', value: '{{ $candidate->student->name}}' }, //Added Student Name
            ];

            // Define the table headers
            const headers = [
                { header: 'Title', dataKey: 'title' },
                { header: 'Value', dataKey: 'value' },
            ];

            // Convert data to the format expected by autoTable
            const tableData = data.map(item => ({
                title: item.title,
                value: item.value,
            }));

            doc.autoTable({
                head: headers,
                body: tableData,
                startY: 30,
            });
            doc.save(filename);
        }
    </script>
@endsection
