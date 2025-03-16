@extends('admin.app')
@section('admin_content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ $instruction->title }}</h4>
                    </div>

                    <div class="card-body">
                        <p>{!! $instruction->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
