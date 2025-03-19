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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Leave</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apply</a></li>
                        <li class="breadcrumb-item active">Edit Leave Application</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Leave Application</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leave-apply.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('leave-apply.update', $leaveApply->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-select select2" id="role_id" name="role_id" required>
                            <option value="1" {{ $leaveApply->role_id == '1' ? 'selected' : '' }}>Student</option>
                            <option value="2" {{ $leaveApply->role_id == '2' ? 'selected' : '' }}>Teacher</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="application_to" class="form-label">Application To</label>
                        <select class="form-select select2" id="application_to" name="application_to" required>
                            <option value="">Select User</option>
                            @foreach ($applicationTo as $user)
                                <option value="{{ $user->id }}" {{ $leaveApply->application_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="leave_category_id" class="form-label">Leave Category</label>
                        <select class="form-select select2" id="leave_category_id" name="leave_category_id" required>
                            <option value="">Select Leave Category</option>
                            @foreach ($leaveCategories as $category)
                                <option value="{{ $category->id }}" {{ $leaveApply->leave_category_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $leaveApply->start_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $leaveApply->end_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="reason_{{$editorId}}" name="reason" rows="3" required>{!! $leaveApply->reason !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        @if($leaveApply->attachment)
                            <a href="{{ asset('uploads/leave-apply/' . $leaveApply->attachment) }}" class="btn btn-success mt-2" download>
                                <i class="ri-download-line"></i> Download Current File
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>


    <script>
        ClassicEditor
            .create(document.querySelector('#reason_{{$editorId}}'))   //pass editor id from controller $editorId = (int) $id;
            .catch(error => {
                console.error(error);
            });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

@endsection
