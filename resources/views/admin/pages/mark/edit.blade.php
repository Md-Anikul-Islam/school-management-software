@extends('admin.app')
@section('admin_content')
    <!-- Select2 and Toastr Styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Mark</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Mark</h4>
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
                <!-- The Form for loading students -->
                <form id="mark-form" method="POST" action="{{ route('mark.update', $mark->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-control select2" id="class" name="class" required>
                                    @if(empty($classes))
                                        <option value="">No Class Available</option>
                                    @else
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ $mark->class_id == $class->id ? 'selected' : '' }}>
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
                                            <option value="{{ $exam->id }}" {{ $mark->exam_id == $exam->id ? 'selected' : '' }}>
                                                {{ $exam->name }}
                                            </option>
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
                                        <option value="{{ $section->id }}" data-class="{{ $section->class_id }}" {{ $mark->section_id == $section->id ? 'selected' : '' }}>
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
                                            <option value="{{ $schedule->subject->id }}" data-exam="{{ $schedule->exam->id }}" {{ $mark->subject_id == $schedule->subject->id ? 'selected' : '' }}>
                                                {{ $schedule->subject->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <!-- This is the first submit button; it will be auto-triggered -->
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

    <!-- Include jQuery, Toastr, and Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- DataTables and Select2 scripts should be included as needed -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right"
        };
    </script>

    <!-- Pass previous marks from the controller to JavaScript -->
    <script>
        var previousMarks = {!! json_encode($marks) !!};
    </script>

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

            // Run filterSections() on page load and when class changes
            filterSections();
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

                // Auto-select the first subject if available
                $('#subject option:eq(1)').prop('selected', true);
            }

            // Run filterSubjects() on page load and when exam changes
            filterSubjects();
            $('#exam').on('change', function () {
                filterSubjects();
            });

            // AJAX submission to load the students table
            $('#mark-form').on('submit', function (e) {
                e.preventDefault();
                $('#loading').show();

                let class_id = $('#class').val();
                let exam_id = $('#exam').val();
                let section_id = $('#section').val();
                let subject_id = $('#subject').val();

                if (!class_id || !exam_id || !section_id || !subject_id) {
                    alert("All fields are required.");
                    $('#loading').hide();
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
                        $('#loading').hide();
                        let students = response.students;
                        let tableBody = $('table tbody');
                        tableBody.empty();

                        if ($.fn.DataTable.isDataTable("#basic-datatable")) {
                            $('#basic-datatable').DataTable().destroy();
                        }

                        if (students.length > 0) {
                            $.each(students, function (index, student) {
                                // Find the student's previous marks
                                let studentMark = previousMarks.find(m => m.student_id == student.id);

                                // Default values
                                let examMark = studentMark ? studentMark.exam_mark : '';
                                let attendance = studentMark ? studentMark.attendance : '';
                                let classTest = studentMark ? studentMark.class_test : '';
                                let assignment = studentMark ? studentMark.assignment : '';

                                tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td><img src="/uploads/students/${student.photo}" width="50"></td>
                                        <td>${student.name}</td>
                                        <td>${student.roll}</td>
                                        <td>
                                            <input type="hidden" name="student_id[]" value="${student.id}">
                                            <input type="number" name="exam_mark[${student.id}]" class="form-control" value="${examMark}">
                                        </td>
                                        <td>
                                            <input type="number" name="attendance[${student.id}]" class="form-control" value="${attendance}">
                                        </td>
                                        <td>
                                            <input type="number" name="class_test[${student.id}]" class="form-control" value="${classTest}">
                                        </td>
                                        <td>
                                            <input type="number" name="assignment[${student.id}]" class="form-control" value="${assignment}">
                                        </td>
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
                        $('#loading').hide();
                        alert("Something went wrong!");
                    }
                });
            });

            // Bind the final submission for marks
            $('#new-submit').on('click', function () {
                let formData = $('form').serializeArray();

                $.ajax({
                    url: "{{ route('mark.update', $mark->id) }}",
                    type: "POST",  // Use POST
                    data: formData.concat([{ name: "_method", value: "PUT" }]), // Include _method override
                    success: function (response) {
                        if (response.status === "success") {
                            toastr.success(response.message);
                        } else {
                            alert("Error submitting marks.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("AJAX Error Status:", status);
                        console.log("AJAX Full Response:", xhr.responseText);
                        alert("Something went wrong! Open console for details.");
                    }
                });
            });

            // Auto-submit the form on page load so that the students are loaded with previous marks (edit mode)
            $('#mark-form').trigger('submit');
        });
    </script>
@endsection
