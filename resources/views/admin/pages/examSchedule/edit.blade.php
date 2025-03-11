@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Exam Schedule</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Exam Schedule</h4>
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
                <form action="{{ route('exam-schedule.update', $examSchedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-control" id="class_id" name="class_id" required
                                onchange="fetchSectionsAndSubjects(this.value)">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option
                                    value="{{ $class->id }}" {{ $examSchedule->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select class="form-control" id="section_id" name="section_id" required>
                            <option value="">Select Section</option>
                            <!-- Sections will be dynamically populated here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-control" id="subject_id" name="subject_id" required>
                            <option value="">Select Subject</option>
                            <!-- Subjects will be dynamically populated here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exam_id" class="form-label">Exam</label>
                        <select class="form-control" id="exam_id" name="exam_id" required>
                            <option value="">Select Exam</option>
                            @foreach($exam as $ex)
                                <option
                                    value="{{ $ex->id }}" {{ $examSchedule->exam_id == $ex->id ? 'selected' : '' }}>{{ $ex->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $examSchedule->date }}"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="time_from" class="form-label">Time From</label>
                        <input type="time" class="form-control" id="time_from" name="time_from"
                               value="{{ $examSchedule->time_from }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="time_to" class="form-label">Time To</label>
                        <input type="time" class="form-control" id="time_to" name="time_to"
                               value="{{ $examSchedule->time_to }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_no" class="form-label">Room No</label>
                        <input type="text" class="form-control" id="room_no" name="room_no"
                               value="{{ $examSchedule->room_no }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

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

                        // Pre-select the section for the exam schedule
                        const selectedSection = @json($examSchedule->section_id ?? '');
                        const sectionOption = sectionDropdown.querySelector(`option[value="${selectedSection}"]`);
                        if (sectionOption) {
                            sectionOption.selected = true;
                        }
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

                        // Pre-select the subject for the exam schedule
                        const selectedSubject = @json($examSchedule->subject_id ?? '');
                        const subjectOption = subjectDropdown.querySelector(`option[value="${selectedSubject}"]`);
                        if (subjectOption) {
                            subjectOption.selected = true;
                        }
                    });
            } else {
                document.getElementById('section_id').innerHTML = '<option value="">Select Section</option>'; // Clear sections
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
