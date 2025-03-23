@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Create Folder Inside</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Folder Inside {{ $folder->name }}</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('media-create')
                    <form action="{{ route('media.createFolder') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="folder-name" class="form-label">Folder Name</label>
                            <input type="text" class="form-control" id="folder-name" name="name" required>
                        </div>

                        <input type="hidden" name="parent_id" value="{{ $folder->id }}">

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
