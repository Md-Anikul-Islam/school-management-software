@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Asset Assignment Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Asset Assignment Details</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('asset-assignment.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    <a href="{{ route('asset-assignment.download.pdf', $assetAssignment->id) }}" class="btn btn-success">Download PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label">Role</label>--}}
{{--                            <p class="form-control-static">{{ $assetAssignment->role->name }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Asset</label>
                            <p class="form-control-static">{{ $assetAssignment->asset->title }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Assign Quantity</label>
                            <p class="form-control-static">{{ $assetAssignment->assign_quantity }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <p class="form-control-static">{{ $assetAssignment->due_date }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Check Out Date</label>
                            <p class="form-control-static">{{ $assetAssignment->check_out_date }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Check In Date</label>
                            <p class="form-control-static">{{ $assetAssignment->check_in_date }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <p class="form-control-static">{{ $assetAssignment->status }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <p class="form-control-static">{{ $assetAssignment->note }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <p class="form-control-static">{{ $assetAssignment->location->location }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <p class="form-control-static">{{ $assetAssignment->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Updated At</label>
                            <p class="form-control-static">{{ $assetAssignment->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
