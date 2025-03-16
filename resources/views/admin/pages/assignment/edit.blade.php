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
                        <li class="breadcrumb-item active">Edit Assignment</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Assignment</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('assignment-list')
                        <a href="{{ route('assignment.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('assignment.update', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $assignment->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $assignment->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" value="{{ $assignment->deadline }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-control select2" id="class_id" name="class_id" required onchange="fetchSectionsAndSubjects(this.value)">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $assignment->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select class="form-control select2" id="section_id" name="section_id[]" multiple required>
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
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file">
                        @if($assignment->file)
                            <a href="{{ asset('uploads/assignment/' . $assignment->file) }}" class="btn btn-success mt-2" download>
                                <i class="ri-download-line"></i> Download Current File
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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
                        sectionDropdown.innerHTML = ''; // Clear existing options
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.text = section.name;
                            sectionDropdown.appendChild(option);
                        });

                        // Pre-select sections for the assignment
                        const selectedSections = @json($assignment->section_id ?? []);
                        selectedSections.forEach(sectionId => {
                            const option = sectionDropdown.querySelector(`option[value="${sectionId}"]`);
                            if (option) {
                                option.selected = true;
                            }
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

                        // Pre-select the subject for the assignment
                        const selectedSubject = @json($assignment->subject_id ?? '');
                        const subjectOption = subjectDropdown.querySelector(`option[value="${selectedSubject}"]`);
                        if (subjectOption) {
                            subjectOption.selected = true;
                        }
                    });
            } else {
                document.getElementById('section_id').innerHTML = ''; // Clear sections if no class is selected
                document.getElementById('subject_id').innerHTML = '<option value="">Select Subject</option>'; // Clear subjects
            }
        }

        // Fetch sections and subjects when the page loads (for edit mode)
        document.addEventListener('DOMContentLoaded', function () {
            const classId = document.getElementById('class_id').value;
            if (classId) {
                fetchSectionsAndSubjects(classId);
            }
        });
    </script>
@endsection
