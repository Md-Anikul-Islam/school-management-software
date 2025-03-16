@extends('admin.app')
@section('admin_content')
    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include Bootstrap Datepicker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

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
                        <li class="breadcrumb-item active">Add Exam Schedule</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Exam Schedule</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('exam-schedule-create')
                        <a href="{{ route('exam-schedule.index') }}" class="btn btn-primary"><span><i
                                    class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('exam-schedule.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-control select2" id="class_id" name="class_id" required
                                onchange="fetchSectionsAndSubjects(this.value)">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select class="form-control select2" id="section_id" name="section_id" required>
                            <option value="">Select Section</option>
                            <!-- Sections will be dynamically populated here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-control select2" id="subject_id" name="subject_id" required>
                            <option value="">Select Subject</option>
                            <!-- Subjects will be dynamically populated here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exam_id" class="form-label">Exam</label>
                        <select class="form-control select2" id="exam_id" name="exam_id" required>
                            <option value="">Select Exam</option>
                            @foreach($exam as $ex)
                                <option value="{{ $ex->id }}">{{ $ex->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" class="form-control datepicker" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time_from" class="form-label">Time From</label>
                        <input type="time" class="form-control" id="time_from" name="time_from" required>
                    </div>
                    <div class="mb-3">
                        <label for="time_to" class="form-label">Time To</label>
                        <input type="time" class="form-control" id="time_to" name="time_to" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_no" class="form-label">Room No</label>
                        <input type="text" class="form-control" id="room_no" name="room_no" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Include Bootstrap Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


    <script>
        $(document).ready(function() {
            if (typeof $.fn.select2 !== "undefined") {
                $('.select2').select2();
            } else {
                console.error("Select2 not loaded");
            }
        });
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>

    <script>
        // Fetch sections and subjects based on the selected class
        function fetchSectionsAndSubjects(classId) {
            if (classId) {
                // Fetch sections
                fetch(`/admin/fetch-sections?class_id=${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        const sectionDropdown = document.getElementById('section_id');
                        sectionDropdown.innerHTML = '<option value="">Select Section</option>'; // Clear existing options
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.text = section.name;
                            sectionDropdown.appendChild(option);
                        });
                    });

                // Fetch subjects
                fetch(`/admin/fetch-subjects?class_id=${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        const subjectDropdown = document.getElementById('subject_id');
                        subjectDropdown.innerHTML = '<option value="">Select Subject</option>'; // Clear existing options
                        data.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.text = subject.name;
                            subjectDropdown.appendChild(option);
                        });
                    });
            } else {
                document.getElementById('section_id').innerHTML = '<option value="">Select Section</option>'; // Clear sections
                document.getElementById('subject_id').innerHTML = '<option value="">Select Subject</option>'; // Clear subjects
            }
        }
    </script>
@endsection
