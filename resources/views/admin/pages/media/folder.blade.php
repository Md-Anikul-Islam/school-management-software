@extends('admin.app')
@section('admin_content')
    <style>
        .media-item {
            display: inline-block;
            width: 200px;
            margin: 10px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .media-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Upload Your Files</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('media.index') }}" class="btn btn-primary"><span><i
                                class="ri-arrow-go-back-line"></i></span>Back</a>
                    <div>
                        @can('media-create')
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#upload-image-modal"><span><i
                                        class="ri-upload-2-line"></i></span>Upload Image
                            </button>
{{--                            <a href="{{ route('media.createFolder', ['folder' => $folder->id]) }}"--}}
{{--                               class="btn btn-primary">--}}
{{--                                <span><i class="ri-add-fill"></i></span>Create Folder Inside--}}
{{--                            </a>--}}
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="media-container">
                    @foreach ($items as $item)
                        <div class="media-item">
                            @if ($item->type == 'folder')
                                <a href="{{ route('media.showFolder', $item->id) }}">
                                    <span><i class="ri-folder-line"></i></span><br>
                                    {{ $item->name }}
                                </a>
                            @else
                                <img src="{{ asset($item->path) }}" alt="{{ $item->name }}">
                                <p>{{ $item->name }}</p>
                            @endif
                            @can('media-delete')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                   data-bs-target="#delete-modal-{{ $item->id }}"><i
                                        class="ri-delete-bin-6-fill"></i></a>
                                <div id="delete-modal-{{ $item->id }}" class="modal fade" tabindex="-1"
                                     role="dialog" aria-labelledby="delete-modal-label-{{ $item->id }}"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="delete-modal-label-{{ $item->id }}">Delete</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are you sure you want to delete this item?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close
                                                </button>
                                                <form action="{{ route('media.destroy', $item->id) }}"
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
                    @endforeach
                </div>

                <div id="upload-image-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="upload-image-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="upload-image-modalLabel">Upload Image</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('media.uploadImage') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="image-file" class="form-label">Select Image</label>
                                        <input type="file" class="form-control" id="image-file" name="image" required>
                                    </div>
                                    <input type="hidden" name="parent_id" value="{{ $folder->id }}">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
