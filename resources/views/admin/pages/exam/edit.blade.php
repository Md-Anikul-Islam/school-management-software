@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Exam</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Exam</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('exam-list')
                        <a href="{{ route('exam.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('exam.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Exam Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $exam->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Exam Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $exam->date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3" required>{{ $exam->note }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="do_not_delete" name="do_not_delete" {{ $exam->do_not_delete ? 'checked' : '' }}>
                            <label class="form-check-label" for="do_not_delete">Do not delete</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
