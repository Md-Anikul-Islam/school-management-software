@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Create Hostel Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Hostel Category</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('hostel-category-list')
                        <a href="{{ route('hostel-category.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('hostel-category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="hostel_id" class="form-label">Hostel Name</label>
                        <select class="form-control" id="hostel_id" name="hostel_id" required>
                            <option value="">Select Hostel</option>
                            @foreach($hostels as $hostel)
                                <option value="{{ $hostel->id }}">{{ $hostel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="class_type" class="form-label">Class Type</label>
                        <input type="text" class="form-control" id="class_type" name="class_type" required>
                    </div>
                    <div class="mb-3">
                        <label for="hostel_fee" class="form-label">Hostel Fee</label>
                        <input type="number" class="form-control" id="hostel_fee" name="hostel_fee" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
