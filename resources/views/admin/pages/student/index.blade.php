@extends('admin.app')
@section('admin_content')
    <style>
        label {
            text-transform: capitalize;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $pageTitle }}</h4>
            </div>
        </div>
    </div>
    @include('admin.pages.validation_error_message')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('student-create')
                        <a href="{{ route('student.create') }}" class="btn btn-primary">Add Student</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-bordered table-striped dt-responsive w-100">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Roll</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if($student->photo)
                                    <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="{{ $student->name }}" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->roll }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->status }}</td>
                            <td>
                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info">Edit</a>
                                <a href="{{ route('student.show', $student->id) }}" class="btn btn-primary">View</a>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
