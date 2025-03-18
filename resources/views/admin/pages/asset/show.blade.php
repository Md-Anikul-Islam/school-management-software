@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Asset Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Asset Details</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('asset.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    <a href="{{ route('asset.download.pdf', $asset->id) }}" class="btn btn-success">Download PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Serial</label>
                            <p class="form-control-static">{{ $asset->serial }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <p class="form-control-static">{{ $asset->title }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <p class="form-control-static">{{ $asset->status }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <p class="form-control-static">{{ $asset->assetCategory->category }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <p class="form-control-static">{{ $asset->location->location }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Condition</label>
                            <p class="form-control-static">{{ $asset->condition }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Create Date</label>
                            <p class="form-control-static">{{ $asset->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($asset->attachment)
                            <div class="mb-3">
                                <label class="form-label">Attachment</label>
                                <p class="form-control-static">
                                    <a href="{{ asset('storage/uploads/assets/' . $asset->attachment) }}" target="_blank">View Attachment</a>
                                </p>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Attachment</label>
                                <p class="form-control-static">No Attachment</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
