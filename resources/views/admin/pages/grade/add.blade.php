@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Create Grade</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Grade</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('grade-create')
                        <a href="{{ route('grade.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('grade.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="grade_name" class="form-label">Grade Name</label>
                        <input type="text" class="form-control" id="grade_name" name="grade_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="grade_point" class="form-label">Grade Point</label>
                        <input type="number" class="form-control" id="grade_point" name="grade_point" required>
                    </div>
                    <div class="mb-3">
                        <label for="mark_from" class="form-label">Mark From</label>
                        <input type="number" class="form-control" id="mark_from" name="mark_from" required min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="mark_upto" class="form-label">Mark Upto</label>
                        <input type="number" class="form-control" id="mark_upto" name="mark_upto" required min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
