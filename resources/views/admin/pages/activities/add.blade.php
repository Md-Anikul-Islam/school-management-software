@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Add Activities</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Activities</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('activities-list')
                        <a href="{{ route('activities.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="activity_category_id" class="form-label">Activity Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="activity_category_id" name="activity_category_id" required>
                            <option value="">Select Activity Category</option>
                            @foreach($activityCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('activity_category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="time_frame" class="form-label">Time Frame <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="time_frame_start" name="time_frame_start" required>
                                <small class="text-muted">Start Time</small>
                                @error('time_frame_start')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="time_frame_end" name="time_frame_end" required>
                                <small class="text-muted">End Time</small>
                                @error('time_frame_end')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="time_at" class="form-label">Time At</label>
                        <input type="time" class="form-control" id="time_at" name="time_at">
                        @error('time_at')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        <small class="text-muted">Allowed file types: jpg, jpeg, png, pdf (max 2MB)</small>
                        @error('attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Activities</button>
                </form>
            </div>
        </div>
    </div>
@endsection
