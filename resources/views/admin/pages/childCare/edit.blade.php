@extends('admin.app')
@section('admin_content')

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
                        <li class="breadcrumb-item active">Edit Child Care</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Child Care</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('childcare-list')
                        <a href="{{ route('childcare.index') }}" class="btn btn-primary">
                            <i class="ri-arrow-go-back-line"></i> Back
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('childcare.update', $childCare->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-select select2" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option
                                    value="{{ $class->id }}" {{ $childCare->class_id == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student</label>
                        <select class="form-select select2" id="student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            {{-- Students for the selected class will be loaded here via AJAX --}}
                        </select>
                        @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="receiver_name" class="form-label">Receiver Name</label>
                        <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                               value="{{ $childCare->receiver_name }}" required>
                        @error('receiver_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $childCare->phone }}"
                               required>
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="drop_time" class="form-label">Drop Time</label>
                        <input type="time" class="form-control" id="drop_time" name="drop_time"
                               value="{{ $childCare->drop_time }}" required>
                        @error('drop_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="receive_time" class="form-label">Receive Time</label>
                        <input type="time" class="form-control" id="receive_time" name="receive_time"
                               value="{{ $childCare->receive_time }}" required>
                        @error('receive_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment"
                                  rows="3">{{ $childCare->comment }}</textarea>
                        @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
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
        });
    </script>

    <script>
        $(document).ready(function () {
            // Function to load students based on selected class
            function loadStudents(classId, selectedStudentId = null) {
                if (classId) {
                    $.ajax({
                        url: '{{ route('get-students-by-class') }}',
                        type: 'GET',
                        data: {class_id: classId},
                        dataType: 'json',
                        success: function (data) {
                            $('#student_id').empty();
                            $('#student_id').append('<option value="">Select Student</option>');
                            $.each(data, function (key, value) {
                                var selected = (key == selectedStudentId) ? 'selected' : '';
                                $('#student_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#student_id').empty();
                    $('#student_id').append('<option value="">Select Student</option>');
                }
            }

            // Load students on class change
            $('#class_id').on('change', function () {
                var classId = $(this).val();
                loadStudents(classId);
            });

            // Load students on page load if a class is already selected
            var initialClassId = $('#class_id').val();
            var selectedStudentId = "{{ $childCare->student_id ?? '' }}";
            loadStudents(initialClassId, selectedStudentId);
        });
    </script>

@endsection
