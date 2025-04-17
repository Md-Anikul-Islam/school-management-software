@extends('admin.app')
@section('admin_content')

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px; /* Same as Bootstrap .form-control */
            border: 1px solid #ced4da; /* Same as Bootstrap input border */
            border-radius: 5px; /* Rounded corners */
            padding: 6px 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px; /* Align text properly */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px; /* Align arrow with input */
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Candidate</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Candidate</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('candidate-list')
                        <a href="{{ route('candidate.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @can('candidate-edit')
                    <form action="{{ route('candidate.update', $candidate->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student Name</label>
                            <select class="form-control select2" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $candidate->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="student_registration_number" class="form-label">Student Registration Number</label>
                            <input type="text" class="form-control" id="student_registration_number" name="student_registration_number" value="{{ $candidate->student_registration_number }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <input type="text" class="form-control" id="class_id" name="class_id" value="{{ $candidate->class_id }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="section_id" class="form-label">Section</label>
                            <input type="text" class="form-control" id="section_id" name="section_id" value="{{ $candidate->section_id }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="application_verified_by" class="form-label">Application Verified By</label>
                            <input type="text" class="form-control" id="application_verified_by" name="application_verified_by" value="{{ $candidate->application_verified_by }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_of_verification" class="form-label">Date of Verification</label>
                            <input type="date" class="form-control" id="date_of_verification" name="date_of_verification" value="{{ $candidate->date_of_verification }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            if (typeof $.fn.select2 !== "undefined") {
                $('.select2').select2();
            } else {
                console.error("Select2 not loaded");
            }



            $('#student_id').on('change', function() {
                var studentId = this.value;
                var studentRegInput = document.getElementById('student_registration_number');
                var studentClassInput = document.getElementById('class_id');
                var studentSectionInput = document.getElementById('section_id');


                if (studentId) {
                    fetch('/get-student-data/' + studentId)
                        .then(response => response.json())
                        .then(data => {
                            studentRegInput.value = data.reg_no;
                            studentClassInput.value = data.class_id;
                            studentSectionInput.value = data.section_id;
                        });
                } else {
                    studentRegInput.value = '';
                    studentClassInput.value = '';
                    studentSectionInput.value = '';
                }
            });
        });
    </script>

@endsection


