@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Book</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Book</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('books-list')
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="ri-arrow-go-back-line"></i> Back
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $book->name }}"
                               required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}"
                               required>
                        @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subject_code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code"
                               value="{{ $book->subject_code }}" required>
                        @error('subject_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ $book->price }}"
                               required>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               value="{{ $book->quantity }}" required>
                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rack_no" class="form-label">Rack No.</label>
                        <input type="text" class="form-control" id="rack_no" name="rack_no" value="{{ $book->rack_no }}"
                               required>
                        @error('rack_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="book_status" class="form-label">Status</label>
                        <select class="form-control" id="book_status" name="status" required>
                            <option value="1" {{ $book->status == 1 ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ $book->status == 0 ? 'selected' : '' }}>Not Available</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
