@extends('admin.app')

@section('admin_content')

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap Datepicker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 6px 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">School</a></li>
                        <li class="breadcrumb-item"><a href="#">Management</a></li>
                        <li class="breadcrumb-item active">Add Student</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Student</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('student-list')
                        <a href="{{ route('student.index') }}" class="btn btn-primary"><i class="ri-arrow-go-back-line"></i> Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-control select2" id="subject" name="subject" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects ?? [] as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Admission Date -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admission_date">Admission Date</label>
                                <input type="text" class="form-control datepicker" id="admission_date" name="admission_date" required>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dob">Date of Birth</label>
                                <input type="text" class="form-control datepicker" id="dob" name="dob" required>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Blood Group -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="blood_group_id">Blood Group</label>
                                <select class="form-control" id="blood_group_id" name="blood_group_id" required>
                                    <option value="">Select Blood Group</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                        <option value="{{ $group }}">{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Religion -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" class="form-control" id="religion" name="religion" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>

                        <!-- Photo Upload -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            if ($.fn.select2) {
                $('.select2').select2();
            } else {
                console.error("Select2 not loaded");
            }

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>

@endsection
