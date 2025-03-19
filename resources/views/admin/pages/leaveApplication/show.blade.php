@extends('admin.app')
@section('admin_content')
    <style>
        .leave-details {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .leave-details h4 {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .leave-details strong {
            display: block;
            margin-bottom: 5px;
        }

        .leave-details span {
            display: block;
            margin-bottom: 10px;
        }

        .leave-details .status-badge {
            margin-top: 15px;
        }

        .leave-details .action-buttons {
            margin-top: 20px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('leave-application.index') }}">Leave</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leave-application.index') }}">Application</a>
                        </li>
                        <li class="breadcrumb-item active">Leave Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Leave Details</h4>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('leave-application.index') }}" class="btn btn-secondary">Go Back</a>
        <a href="{{ route('leave-application.pdf', $leaveApply->id) }}" class="btn btn-primary">Download PDF</a>
    </div>

    <div class="leave-details">
        <h4>User Information</h4>
        <strong>{{ $leaveApply->applicationTo->name }}</strong>
        <span>
            @if($leaveApply->role_id == 1)
                Student
            @else
                Teacher
            @endif
        </span>
        <span>Register NO: 1</span>
        <span>Roll: 1</span>
        <span>Class: Two</span>
        <span>Section: A</span>

        <h4 class="mt-4">Leave Application Details</h4>
        <strong>Date:</strong>
        <span>{{ $leaveApply->created_at->format('d M Y') }}</span>
        <strong>Reason:</strong>
        <span>{!! $leaveApply->reason !!}</span>

        <strong>Schedule:</strong>
        <span>{{ $leaveApply->start_date }} - {{ $leaveApply->end_date }}</span>

        <strong>Available Leave Days:</strong>
        <span>1</span>

        <strong>Leave Day:</strong>
        <span>1</span>

        <strong>Holiday:</strong>
        <span>0</span>

        <strong>Weekend Day:</strong>
        <span>0</span>

        <strong>Total Day:</strong>
        <span>2</span>

        <strong>Category:</strong>
        <span>{{ $leaveApply->leaveCategory->category }}</span>

        <strong>Attachment:
            @if($leaveApply->attachment)
                <a href="{{ asset('uploads/leave-apply/' . $leaveApply->attachment) }}" class="btn btn-success btn-sm"
                   download>
                    <i class="ri-download-line"></i> Download
                </a>
            @else
                <span>No Attachment</span>
            @endif
        </strong>

        <div class="status-badge d-flex justify-content">
            <strong>Application Status: &nbsp</strong>
            @if($leaveApply->status === null)
                <span class="badge bg-warning">Pending</span>
            @elseif($leaveApply->status == 1)
                <span class="badge bg-success">Approved</span>
            @elseif($leaveApply->status == 2)
                <span class="badge bg-danger">Declined</span>
            @endif
        </div>

        <div class="action-buttons">
            @if($leaveApply->status === null)
                <form action="{{ route('leave-application.approve', $leaveApply->id) }}" method="POST"
                      style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                </form>
                <form action="{{ route('leave-application.decline', $leaveApply->id) }}" method="POST"
                      style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                </form>
            @endif
        </div>
    </div>
@endsection
