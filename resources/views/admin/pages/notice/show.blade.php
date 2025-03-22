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
                <h4 class="page-title">Notice View</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('notice.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                            <a href="{{ route('notice.pdf', $notice->id) }}" class="btn btn-success">Download PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5>{{ $notice->title }}</h5>
                    <p>{!! $notice->notice !!}</p>
                    <p>{{ $notice->date }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
