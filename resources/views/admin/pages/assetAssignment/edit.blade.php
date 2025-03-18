@extends('admin.app')
@section('admin_content')
    <div class="row">

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

        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Asset Assignment</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Asset Assignment</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('asset-assignment-list')
                        <a href="{{ route('asset-assignment.index') }}" class="btn btn-primary"><span><i
                                    class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('asset-assignment.update', $assetAssignment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="asset_id" class="form-label">Asset</label>
                        <select class="form-control select2" id="asset_id" name="asset_id" required>
                            <option value="">Select Asset</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ $assetAssignment->asset_id == $asset->id ? 'selected' : '' }}>{{ $asset->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="assign_quantity" class="form-label">Assign Quantity</label>
                        <input type="number" class="form-control" id="assign_quantity" name="assign_quantity" value="{{ $assetAssignment->assign_quantity }}" required>
                    </div>
{{--                    <div class="mb-3">--}}
{{--                        <label for="role_id" class="form-label">Role</label>--}}
{{--                        <select class="form-control select2" id="role_id" name="role_id" required>--}}
{{--                            <option value="">Select Role</option>--}}
{{--                            @foreach($roles as $role)--}}
{{--                                <option value="{{ $role->id }}" {{ $assetAssignment->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <div class="mb-3">
                        <label for="check_out_to" class="form-label">Check Out To</label>
                        <select class="form-control select2" id="check_out_to" name="check_out_to" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $assetAssignment->check_out_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $assetAssignment->due_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="check_out_date" class="form-label">Check Out Date</label>
                        <input type="date" class="form-control" id="check_out_date" name="check_out_date" value="{{ $assetAssignment->check_out_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="check_in_date" class="form-label">Check In Date</label>
                        <input type="date" class="form-control" id="check_in_date" name="check_in_date" value="{{ $assetAssignment->check_in_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="location_id" class="form-label">Location</label>
                        <select class="form-control select2" id="location_id" name="location_id" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $assetAssignment->location_id == $location->id ? 'selected' : '' }}>{{ $location->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control select2" id="status" name="status" required>
                            <option value="Checked Out" {{ $assetAssignment->status == 'Checked Out' ? 'selected' : '' }}>Checked Out</option>
                            <option value="In Storage" {{ $assetAssignment->status == 'In Storage' ? 'selected' : '' }}>In Storage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note_{{$editorId}}" name="note" rows="3" required>{!! $assetAssignment->note !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>


    <script>
        ClassicEditor
            .create(document.querySelector('#note_{{$editorId}}'))   //pass editor id from controller $editorId = (int) $id;
            .catch(error => {
                console.error(error);
            });
    </script>

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
