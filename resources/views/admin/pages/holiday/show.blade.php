@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
                <h4 class="page-title">Holiday View</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('holiday.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                            <a href="{{ route('holiday.pdf', $holiday->id) }}" class="btn btn-success">Download PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @if($holiday->photo)
                        <div style="text-align: center;">
                            <img src="{{ asset('uploads/holidays/' . $holiday->photo) }}" alt="Holiday Photo" style="max-width: 100%; height: auto;">
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                        <div>
                            <strong>From Date:</strong> {{ $holiday->from_date }}
                        </div>
                        <div>
                            <strong>To Date:</strong> {{ $holiday->to_date }}
                        </div>
                    </div>

                    <h5 style="text-align: center; margin-top: 20px;">{{ $holiday->title }}</h5>

                    <div style="text-align: center; margin-top: 10px;">
                        {{ $holiday->from_date }} at {{ date('h:i A', strtotime('12:00')) }} to {{ $holiday->to_date }} at {{ date('h:i A', strtotime('12:00')) }}
                    </div>

                    <p style="margin-top: 20px;">{!! $holiday->details !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
