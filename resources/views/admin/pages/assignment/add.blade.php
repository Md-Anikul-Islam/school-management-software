@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Add Assignment</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Assignment</h4>
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
                <form action="{{ route('assignment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" required>
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-control" id="class_id" name="class_id" required onchange="fetchSectionsAndSubjects(this.value)">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select class="form-control" id="section_id" name="section_id[]" multiple required>
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
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
                        sectionDropdown.innerHTML = ''; // Clear existing options
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
                document.getElementById('section_id').innerHTML = ''; // Clear sections if no class is selected
                document.getElementById('subject_id').innerHTML = '<option value="">Select Subject</option>'; // Clear subjects
            }
        }
    </script>
@endsection
