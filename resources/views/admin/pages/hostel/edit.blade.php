@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Hostel</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Hostel</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('hostel-list')
                        <a href="{{ route('hostel.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @can('hostel-edit')
                    <form action="{{ route('hostel.update', $hostel->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Hostel Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $hostel->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Hostel Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="1" {{ $hostel->type == '1' ? 'selected' : '' }}>Boys</option>
                                <option value="2" {{ $hostel->type == '2' ? 'selected' : '' }}>Girls</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" required>{{ $hostel->address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" id="note" name="note">{{ $hostel->note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
