@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Assign Library Member</li>
                    </ol>
                </div>
                <h4 class="page-title">Assign Library Member</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('library-member-list')
                        <a href="{{ route('library-members.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('library-members.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $studentId }}">

                    <div class="mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="student_name" value="{{ $student->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="library_id" class="form-label">Library Name</label>
                        <select class="form-control" id="library_id" name="library_id" required>
                            <option value="">Select Library</option>
                            @foreach ($libraries as $library)
                                <option value="{{ $library->id }}">{{ $library->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="library_code" class="form-label">Library Code</label>
                        <input type="text" class="form-control" id="library_code"  readonly>
                    </div>

                    <div class="mb-3">
                        <label for="library_fee" class="form-label">Library Fee</label>
                        <input type="text" class="form-control" id="library_fee"  readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('library_id').addEventListener('change', function() {
            var libraryId = this.value;
            var libraryCodeInput = document.getElementById('library_code');
            var libraryFeeInput = document.getElementById('library_fee');


            if (libraryId) {
                fetch('/get-library-details/' + libraryId) // Create this route in your Laravel app
                    .then(response => response.json())
                    .then(data => {
                        libraryCodeInput.value = data.code;
                        libraryFeeInput.value = data.fee;
                    });
            } else {
                libraryCodeInput.value = '';
                libraryFeeInput.value = '';
            }
        });
    </script>
@endsection
