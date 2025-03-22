@extends('admin.app')
@section('admin_content')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
                        <li class="breadcrumb-item active">Add Mark</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Mark</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('mark-list')
                        <a href="{{ route('mark.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span> Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
{{--                <form action="{{ route('mark.store') }}" method="POST">--}}
                <form id="mark-form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-control select2" id="class" name="class" required>
                                    @if(empty($classes))
                                        <option value="">No Class Available</option>
                                    @else
                                        @foreach($classes as $index => $class)
                                            <option value="{{ $class->id }}" {{ $index == 0 ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exam" class="form-label">Exam</label>
                                <select class="form-control select2" id="exam" name="exam" required>
                                    @if(empty($exams))
                                        <option value="">No Exam Available</option>
                                    @else
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control select2" id="section" name="section" required>
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" data-class="{{ $section->class_id }}">
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-control select2" id="subject" name="subject" required>
                                    @if(empty($subjects))
                                        <option value="">No Subject Available</option>
                                    @else
                                        @foreach($examSchedules as $schedule)
                                            <option value="{{ $schedule->subject->id }}" data-exam="{{ $schedule->exam->id }}">
                                                {{ $schedule->subject->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                    <div id="loading" style="display: none;">
                        <p>Loading students...</p>
                    </div>

                    <div class="mt-3">
                        <table id="basic-datatable" class="table table-striped table-bordered display">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Roll</th>
                                <th>Exam</th>
                                <th>Attendance</th>
                                <th>Class Test</th>
                                <th>Assignment</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="new-submit" class="btn btn-success d-none">Submit Marks</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right" // You can adjust the position
        }
    </script>

    <!-- Include jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.select2').select2();
            $('#basic-datatable').DataTable();

            function filterSections() {
                let selectedClassId = $('#class').val();
                $('#section').html('<option value="">Select Section</option>'); // Reset section dropdown

                @foreach($sections as $section)
                if ({{ $section->class_id }} == selectedClassId) {
                    $('#section').append('<option value="{{ $section->id }}">{{ $section->name }}</option>');
                }
                @endforeach

                // Automatically select the first available section
                $('#section option:eq(1)').prop('selected', true);
            }

            // Run filterSections() on page load
            filterSections();

            // Update sections when class changes
            $('#class').on('change', function () {
                filterSections();
            });

            function filterSubjects() {
                let selectedExamId = $('#exam').val();
                $('#subject').html('<option value="">Select Subject</option>'); // Reset subject dropdown

                @foreach($examSchedules as $schedule)
                if ({{ $schedule->exam->id }} == selectedExamId) {
                    $('#subject').append('<option value="{{ $schedule->subject->id }}">{{ $schedule->subject->name }}</option>');
                }
                @endforeach

                // Auto-select first subject if available
                $('#subject option:eq(1)').prop('selected', true);
            }

            // Run filterSubjects() on page load
            filterSubjects();

            // Update subjects when exam changes
            $('#exam').on('change', function () {
                filterSubjects();
            });

            // Submit Form Using AJAX
            $('form').on('submit', function (e) {
                e.preventDefault();
                $('#loading').show(); // Show loading message

                let class_id = $('#class').val();
                let exam_id = $('#exam').val();
                let section_id = $('#section').val();
                let subject_id = $('#subject').val();

                if (!class_id || !exam_id || !section_id || !subject_id) {
                    alert("All fields are required.");
                    $('#loading').hide(); // Hide loading if validation fails
                    return;
                }

                $.ajax({
                    url: "{{ route('get.exam.students') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        class_id: class_id,
                        exam_id: exam_id,
                        section_id: section_id,
                        subject_id: subject_id
                    },
                    success: function (response) {
                        $('#loading').hide(); // Hide loading on success
                        let students = response.students;
                        let tableBody = $('table tbody');
                        tableBody.empty();

                        if ($.fn.DataTable.isDataTable("#basic-datatable")) {
                            $('#basic-datatable').DataTable().destroy();
                        }

                        if (students.length > 0) {
                            $.each(students, function (index, student) {
                                tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td><img src="/uploads/students/${student.photo}" width="50"></td>
                                        <td>${student.name}</td>
                                        <td>${student.roll}</td>
                                        <td><input type="hidden" name="student_id[]" value="${student.id}">
                                            <input type="number" name="exam_mark[${student.id}]" class="form-control">
                                        </td>
                                        <td><input type="number" name="attendance[${student.id}]" class="form-control"></td>
                                        <td><input type="number" name="class_test[${student.id}]" class="form-control"></td>
                                        <td><input type="number" name="assignment[${student.id}]" class="form-control"></td>
                                    </tr>
                                `);
                            });

                            $('form .btn-primary').hide();
                            $('#new-submit').removeClass('d-none');
                        } else {
                            tableBody.append('<tr><td colspan="8" class="text-center">No students found.</td></tr>');
                        }

                        $('#basic-datatable').DataTable();
                    },
                    error: function () {
                        $('#loading').hide(); // Ensure it hides on error
                        alert("Something went wrong!");
                    }
                });
            });

            $('#new-submit').on('click', function () {
                // let formData = $('form').serialize(); // Get all form data
                let formData = $('form').serializeArray();
                console.log("Form Data:", formData);

                $.ajax({
                    url: "{{ route('mark.store') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.status === "success") {
                            // alert("Marks submitted successfully!");
                            toastr.success(response.message); // Display toastr notification
                            // location.reload(); // Reload page after submission
                        } else {
                            alert("Error submitting marks.");
                        }
                    },
                    error: function () {
                        alert("Something went wrong!");
                    }
                });
            });

        });
    </script>
@endsection
