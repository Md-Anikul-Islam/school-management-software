@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Activities</li>
                    </ol>
                </div>
                <h4 class="page-title">Activities</h4>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                @can('activities-create')
                    <a href="{{ route('activities.create') }}" class="btn btn-primary"><span><i
                                class="ri-add-line"></i></span>Add New Activity</a>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        @forelse ($activities as $activity)
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-soft-info text-info rounded-circle">
                                            {{ strtoupper(substr($activity->user->name ?? '?', 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div>
                                        <h6 class="mt-0 mb-1">{{ $activity->user->name ?? 'Unknown User' }}</h6>
                                        <p class="mb-0 font-12 text-muted">
                                            Shared Publicly
                                            - {{ \Carbon\Carbon::parse($activity->created_at)->format('l jS o M Y H:i:s') }}
                                        </p>
                                    </div>
                                    <div>
                                        <span style="background-color: #0a53be !important;" class="badge badge-success">{{ $activity->activityCategory->title }}</span>
                                    </div>
                                </div>
                            </div>
                            @can('activities-delete')
                                <a class="btn btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#danger-header-modal-activity-{{ $activity->id }}"><i
                                        class="ri-close-line"></i></a>
                                <div id="danger-header-modal-activity-{{ $activity->id }}" class="modal fade"
                                     tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="danger-header-modalLabel-activity-{{ $activity->id }}"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel-activity-{{ $activity->id }}">
                                                    Delete</h4>
                                                <button type="button" class="btn btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are you sure you want to delete this activity?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close
                                                </button>
                                                <form action="{{ route('activities.destroy', $activity->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        <div class="w-100">
                            <div class="w-100 activity-image-container">
                                @if ($activity->attachment)
                                    <img class="w-100 object-fit-contain border rounded"
                                         src="{{ asset('uploads/attachments/' . $activity->attachment) }}"
                                         alt="Activity Attachment" style="height: 500px;">
                                @endif
                            </div>
                            <div class="mt-4">
                                <h5 class="mt-0 mb-1">{{ $activity->description }}</h5>
                                <p class="mb-2 text-muted">
                                    <i class="ri-calendar-event-line me-1"></i>
                                    {{ \Carbon\Carbon::parse($activity->time_frame_start)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($activity->time_frame_end)->format('h:i A') }}
                                    @if ($activity->time_at)
                                        &nbsp &nbsp &nbsp &nbsp
                                        <i class="ri-time-line me-1"></i>{{ \Carbon\Carbon::parse($activity->time_at)->format('h:i A') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No activities found.</div>
            </div>
        @endforelse
    </div>
@endsection
