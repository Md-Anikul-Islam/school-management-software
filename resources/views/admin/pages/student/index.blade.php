@extends('admin.app')
@section('admin_content')
    <style>
        label {
            text-transform: capitalize;
        }

        /* Toggle switch styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px; /* Width of the switch */
            height: 23px; /* Height of the switch */
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc; /* Default background color */
            transition: 0.4s; /* Smooth transition */
            border-radius: 23px; /* Rounded corners */
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 19px; /* Height of the slider circle */
            width: 19px; /* Width of the slider circle */
            border-radius: 50%; /* Make it round */
            left: 2px; /* Initial position from the left */
            bottom: 2px; /* Initial position from the bottom */
            background-color: white; /* Color of the slider circle */
            transition: 0.4s; /* Smooth transition */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
        }

        input:checked + .slider {
            background-color: #4CAF50; /* Background color when checked */
        }

        input:checked + .slider:before {
            transform: translateX(17px); /* Move the slider circle to the right */
        }

        /* Optional: Add a focus state for accessibility */
        input:focus + .slider {
            box-shadow: 0 0 1px #4CAF50;
        }


        table.table-bordered.dataTable th, table.table-bordered.dataTable td {
            border-left-width: 0;
            vertical-align: middle;
            text-align: center;
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
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
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
                                    <img src="{{ asset('uploads/students/' . $student->photo) }}"
                                         alt="{{ $student->name }}" width="70" class="img-thumbnail">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->roll }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <form action="{{ route('student.update_status', $student->id) }}" method="POST"
                                      class="status-form">
                                    @csrf
                                    @method('PUT')
                                    <label class="switch">
                                        <input type="checkbox" name="status" value="1"
                                               {{ $student->status == 1 ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <span class="slider round"></span>
                                    </label>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info"><i
                                        class="ri-edit-line"></i></a>
                                <a href="{{ route('student.show', $student->id) }}" class="btn btn-primary"><i class="ri-eye-fill"></i></a>
                                @can('student-delete')
                                    <a class="btn btn-danger" data-bs-toggle="modal"
                                       data-bs-target="#danger-header-modal{{ $student->id }}"><i class="ri-delete-bin-6-fill"></i></a>
                                    <div id="danger-header-modal{{ $student->id }}" class="modal fade" tabindex="-1"
                                         role="dialog" aria-labelledby="danger-header-modalLabel{{ $student->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-danger">
                                                    <h4 class="modal-title"
                                                        id="danger-header-modalLabel{{ $student->id }}">Delete</h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mt-0">Are you sure you want to delete this student?</h5>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <form action="{{ route('student.destroy', $student->id) }}"
                                                          method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
