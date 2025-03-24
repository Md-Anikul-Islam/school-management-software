@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Activities Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Activities Category</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('activities-category-list')
                        <a href="{{ route('activities-category.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('activities-category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $category->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="font_awesome_icon" class="form-label">Font Awesome Icon</label>
                        <input type="text" class="form-control" id="font_awesome_icon" name="font_awesome_icon" value="{{ $category->font_awesome_icon }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
