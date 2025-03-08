@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Student Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Student Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('student-create')
                        <a href="{{ route('student.index') }}" class="btn btn-primary">Go Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <p>{{ $student->name }}</p>
                </div>
                <div class="mb-3">
                    <label for="guardian" class="form-label">Guardian</label>
                    <p>{{ $student->guardian->name }}</p>
                </div>
                <!-- Repeat similar fields for other _id relationships -->
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <div>
                        @if($student->photo)
                            <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="{{ $student->name }}" width="100" class="img-thumbnail">
                        @else
                            <p>No Image</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
