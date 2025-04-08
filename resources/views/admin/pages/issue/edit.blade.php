@extends('admin.app')
@section('admin_content')

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px; /* Same as Bootstrap .form-control */
            border: 1px solid #ced4da; /* Same as Bootstrap input border */
            border-radius: 5px; /* Rounded corners */
            padding: 6px 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px; /* Align text properly */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px; /* Align arrow with input */
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Issue</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Issue</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('issue-list')
                        <a href="{{ route('issue.index') }}" class="btn btn-primary">
                            <i class="ri-arrow-go-back-line"></i> Back
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('issue.update', $issue->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="library_id" class="form-label">Library ID</label>
                        <input type="text" class="form-control" id="library_id" name="library_id"
                               value="{{ $issue->library_id }}" required>
                        @error('library_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="book_id" class="form-label">Book</label>
                        <select class="form-select select2" id="book_id" name="book_id" required>
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" data-author="{{ $book->author }}"
                                        data-subject_code="{{ $book->subject_code }}"
                                    {{ $issue->book_id == $book->id ? 'selected' : '' }}>{{ $book->name }}</option>
                            @endforeach
                        </select>
                        @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author"
                               value="{{ $issue->author }}" readonly>
                        @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subject_code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code"
                               value="{{ $issue->subject_code }}" readonly>
                        @error('subject_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="serial_no" class="form-label">Serial No.</label>
                        <input type="text" class="form-control" id="serial_no" name="serial_no"
                               value="{{ $issue->serial_no }}" required>
                        @error('serial_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date"
                               value="{{ $issue->due_date }}" required>
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note">{{ $issue->note }}</textarea>
                        @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            if (typeof $.fn.select2 !== "undefined") {
                $('.select2').select2();
            } else {
                console.error("Select2 not loaded");
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#book_id').change(function() {
                var selectedOption = $(this).find(':selected');
                var author = selectedOption.data('author');
                var subjectCode = selectedOption.data('subject_code');

                $('#author').val(author);
                $('#subject_code').val(subjectCode);
            });

            // Initialize author and subject code on page load
            var selectedOption = $('#book_id').find(':selected');
            $('#author').val(selectedOption.data('author'));
            $('#subject_code').val(selectedOption.data('subject_code'));
        });
    </script>
@endsection
