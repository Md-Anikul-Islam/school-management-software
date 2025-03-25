@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Hostel Member</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Hostel Member</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('hostel-member-list')
                        <a href="{{ route('hostel-members.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('hostel-members.update', $hostelMember->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="student_name" value="{{ $hostelMember->student->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="hostel_id" class="form-label">Hostel Name</label>
                        <select class="form-control" id="hostel_id" name="hostel_id" required>
                            <option value="">Select Hostel</option>
                            @foreach ($hostels as $hostel)
                                @if(
                                    ($hostelMember->student->gender == 1 && $hostel->type == 1) ||
                                    ($hostelMember->student->gender == 2 && $hostel->type == 2)
                                )
                                    <option value="{{ $hostel->id }}" {{ $hostel->id == $hostelMember->hostel_id ? 'selected' : '' }}>{{ $hostel->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="hostel_category_id" class="form-label">Hostel Category</label>
                        <select class="form-control" id="hostel_category_id" name="hostel_category_id" required>
                            <option value="">Select Hostel Category</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var hostelId = document.getElementById('hostel_id').value;
            var categorySelect = document.getElementById('hostel_category_id');

            // Clear existing options
            categorySelect.innerHTML = '<option value="">Select Hostel Category</option>';

            if (hostelId) {
                fetch('/get-hostel-categories/' + hostelId)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(category => {
                            var option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.class_type;
                            option.selected = category.id == '{{ $hostelMember->hostel_category_id }}';
                            categorySelect.appendChild(option);
                        });
                    });
            }

            document.getElementById('hostel_id').addEventListener('change', function() {
                var hostelId = this.value;
                var categorySelect = document.getElementById('hostel_category_id');

                // Clear existing options
                categorySelect.innerHTML = '<option value="">Select Hostel Category</option>';

                if (hostelId) {
                    fetch('/get-hostel-categories/' + hostelId)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(category => {
                                var option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.class_type;
                                categorySelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
@endsection
