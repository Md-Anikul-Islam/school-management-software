@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Hostel Member Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Hostel Member Details</h4>
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
                    <a href="{{ route('hostel-members.pdf', $hostelMember->id) }}" class="btn btn-success">Download PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <p>{{ $hostelMember->student->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Student Roll</label>
                    <p>{{ $hostelMember->student->roll }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hostel Name</label>
                    <p>{{ $hostelMember->hostel->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hostel Category</label>
                    <p>{{ $hostelMember->hostelCategory->class_type }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hostel Fee</label>
                    <p>{{ $hostelMember->hostelCategory->hostel_fee }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hostel Address</label>
                    <p>{{ $hostelMember->hostel->address }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hostel Type</label>
                    <p>{{ $hostelMember->hostel->type }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
