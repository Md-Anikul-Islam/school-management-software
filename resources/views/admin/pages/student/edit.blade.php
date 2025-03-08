@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Student</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Student</h4>
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
                <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control" name="photo" value="{{ $student->photo }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="guardian_id" class="form-label">Guardian</label>
                        <select class="form-control" id="guardian_id" name="guardian_id" required>
                            <option value="">Select Guardian</option>
                            @foreach($guardians as $guardian)
                                <option value="{{ $guardian->id }}" {{ $student->guardian_id == $guardian->id ? 'selected' : '' }}>{{ $guardian->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Repeat similar dropdowns for other _id fields (class_id, section_id, etc.) -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <div>
                            @if($student->photo)
                                <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="{{ $student->name }}" width="100" class="img-thumbnail">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
