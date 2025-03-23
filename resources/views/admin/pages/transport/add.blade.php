@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Create Transport</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Transport</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('transport-list')
                        <a href="{{ route('transport.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('transport.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="route_name" class="form-label">Route Name</label>
                        <input type="text" class="form-control" id="route_name" name="route_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_no" class="form-label">Vehicle No</label>
                        <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" required>
                    </div>
                    <div class="mb-3">
                        <label for="route_fare" class="form-label">Route Fare</label>
                        <input type="number" class="form-control" id="route_fare" name="route_fare" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
