@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">UNAUTHORIZED ACTION!</li>
                    </ol>
                </div>
                <h4 class="page-title">UNAUTHORIZED ACTION!</h4>
            </div>
        </div>
    </div>
    <div class="p-4 my-auto text-center">
        <div class="d-flex justify-content-center mb-2">
            <img src="{{URL::to('backend/images/svg/404.svg')}}" alt="" class="img-fluid">
        </div>

        <div class="text-center">
            <h1 class="mb-1">403</h1>
            <h4 class="fs-20">You are Not Permitted to access this page</h4>
        </div>
        <a href="{{route('dashboard')}}" class="btn btn-primary w-10"><i class="ri-home-4-line me-1"></i> Back to Dashboard</a>
    </div>
@endsection
