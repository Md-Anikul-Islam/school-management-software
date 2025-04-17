@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Sponsor Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Sponsor Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('sponsor-list')
                        <a href="{{ route('sponsor.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                        <a href="{{ route('sponsor.pdf', $sponsor->id) }}" class="btn btn-success">Download PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                @if($sponsor->photo)
                                    <img src="{{ asset('uploads/sponsors/' . $sponsor->photo) }}" alt="Sponsor Photo" class="img-fluid rounded-circle" style="max-width: 200px;">
                                @else
                                    <img src="{{ asset('placeholder.png') }}" alt="No Photo" class="img-fluid rounded-circle" style="max-width: 200px;">
                                @endif
                                <h4 class="card-title mt-3">{{ $sponsor->name }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Sponsor Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Title:</strong> {{ $sponsor->title }}</p>
                                        <p><strong>Organization Name:</strong> {{ $sponsor->organization_name }}</p>
                                        <p><strong>Email:</strong> {{ $sponsor->email }}</p>
                                        <p><strong>Country:</strong> {{ $sponsor->country }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Sponsor Person Name:</strong> {{ $sponsor->name }}</p>
                                        <p><strong>Address:</strong> {{ $sponsor->address }}</p>
                                        <p><strong>Created At:</strong> {{ $sponsor->created_at }}</p> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
