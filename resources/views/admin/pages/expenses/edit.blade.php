@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Expense</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Expense</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('expense-list')
                        <a href="{{ route('expenses.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span> Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $expense->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $expense->date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file">
                        <small class="text-muted">Allowed file types: jpg, jpeg, png, pdf, doc, docx, xls, xlsx</small>
                        @if($expense->file)
                            <a href="{{ asset('uploads/expenses/' . $expense->file) }}" class="btn btn-success mt-2" download>
                                <i class="ri-download-line"></i> Download Current File
                            </a>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ $expense->note }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
