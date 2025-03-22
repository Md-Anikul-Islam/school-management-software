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
                <h4 class="page-title">Event View</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('event.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                            <a href="{{ route('event.pdf', $event->id) }}" class="btn btn-success">Download PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @if($event->photo)
                        <div style="text-align: center;">
                            <img src="{{ asset('uploads/events/' . $event->photo) }}" alt="Event Photo" style="max-width: 100%; height: auto;">
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                        <div>
                            <strong>From Date:</strong> {{ $event->from_date }}
                        </div>
                        <div>
                            <strong>To Date:</strong> {{ $event->to_date }}
                        </div>
                    </div>

                    <div style="text-align: center; margin-top: 20px;">
                        <button class="btn btn-primary">Going: 0</button>
                        <button class="btn btn-danger">Interested: 1</button>
                    </div>

                    <h5 style="text-align: center; margin-top: 20px;">{{ $event->title }}</h5>

                    <div style="text-align: center; margin-top: 10px;">
                        {{ $event->from_date }} at {{ date('h:i A', strtotime('12:00')) }} to {{ $event->to_date }} at {{ date('h:i A', strtotime('12:00')) }}
                    </div>

                    <p style="margin-top: 20px;">{!! $event->details !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
