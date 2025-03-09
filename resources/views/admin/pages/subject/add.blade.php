@extends('admin.app')
@section('admin_content')
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
                        <select class="form-control" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select class="form-control" id="teacher_id" name="teacher_id" required>
                            <option value="">Select Teacher</option>
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
@endsection
