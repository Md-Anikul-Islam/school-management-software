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
                        <li class="breadcrumb-item active">Edit Asset</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Asset</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('asset-list')
                        <a href="{{ route('asset.index') }}" class="btn btn-primary"><span><i
                                    class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="serial" class="form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial" name="serial" value="{{ $asset->serial }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $asset->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control select2" id="status" name="status" required>
                            <option value="Checked Out" {{ $asset->status == 'Checked Out' ? 'selected' : '' }}>Checked Out</option>
                            <option value="In Storage" {{ $asset->status == 'In Storage' ? 'selected' : '' }}>In Storage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition</label>
                        <select class="form-control select2" id="condition" name="condition" required>
                            <option value="Used" {{ $asset->condition == 'Used' ? 'selected' : '' }}>Used</option>
                            <option value="New" {{ $asset->condition == 'New' ? 'selected' : '' }}>New</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="asset_category_id" class="form-label">Asset Category</label>
                        <select class="form-control select2" id="asset_category_id" name="asset_category_id" required>
                            <option value="">Select Asset Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $asset->asset_category_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location_id" class="form-label">Location</label>
                        <select class="form-control select2" id="location_id" name="location_id" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $asset->location_id == $location->id ? 'selected' : '' }}>{{ $location->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        @if($asset->attachment)
                            <img src="{{ asset('storage/uploads/assets/' . $asset->attachment) }}" alt="Asset Attachment" style="max-width: 150px; margin-top: 10px;">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

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
