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
                        <li class="breadcrumb-item active">Add Subject</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Subject</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('subject-list')
                        <a href="{{ route('subject.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('subject.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-control select2" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teachers</label>
                        <select class="form-control select2" id="teacher_id" name="teacher_id[]" multiple required>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="mandatory">Mandatory</option>
                            <option value="optional">Optional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pass_mark" class="form-label">Pass Mark</label>
                        <input type="number" class="form-control" id="pass_mark" name="pass_mark" required>
                    </div>
                    <div class="mb-3">
                        <label for="final_mark" class="form-label">Final Mark</label>
                        <input type="number" class="form-control" id="final_mark" name="final_mark" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject_author" class="form-label">Subject Author</label>
                        <input type="text" class="form-control" id="subject_author" name="subject_author" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject_code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <strong>Note:</strong> Create a class and teacher before creating a new subject
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
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
@endsection
