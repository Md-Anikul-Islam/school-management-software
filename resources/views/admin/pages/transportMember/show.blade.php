@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Transport Member Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Transport Member Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('transport-member-list')
                        <a href="{{ route('transport-members.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                    <a href="{{ route('transport-members.pdf', $transportMember->id) }}" class="btn btn-success">Download PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <p>{{ $transportMember->student->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Student Roll</label>
                    <p>{{ $transportMember->student->roll }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Route Name</label>
                    <p>{{ $transportMember->transport->route_name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Route Fare</label>
                    <p>{{ $transportMember->fare }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Number</label>
                    <p>{{ $transportMember->transport->vehicle_no }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
