@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Grade</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Grade</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('grade.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('grade.update', $grade->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="grade_name" class="form-label">Grade Name</label>
                        <input type="text" class="form-control" id="grade_name" name="grade_name" value="{{ $grade->grade_name }}"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="grade_point" class="form-label">Grade Point</label>
                        <input type="number" class="form-control" id="grade_point" name="grade_point"
                               value="{{ $grade->grade_point }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="mark_from" class="form-label">Mark From</label>
                        <input type="number" class="form-control" id="mark_from" name="mark_from"
                               value="{{ $grade->mark_from }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="mark_upto" class="form-label">Mark Upto</label>
                        <input type="number" class="form-control" id="mark_upto" name="mark_upto"
                               value="{{ $grade->mark_upto }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ $grade->note }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
