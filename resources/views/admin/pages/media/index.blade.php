@extends('admin.app')
@section('admin_content')
    <style>
        .media-item {
            display: inline-block; /* Revert to inline-block for proper sizing */
            width: 200px;
            height: 200px;
            margin: 10px;
            text-align: center; /* Center content horizontally */
            border: 1px solid #ddd;
            padding: 10px;
            position: relative;
            box-sizing: border-box;
        }

        .media-item img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Ensure images fit within the container */
            vertical-align: middle; /* Center image vertically */
        }

        .folder-icon {
            font-size: 48px;
            color: #FFC107;
            margin-top: 30px; /* Adjust vertical centering */
        }

        .folder-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .delete-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Media</a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $pageTitle }}</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        @can('media-create')
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#create-folder-modal"><span><i
                                        class="ri-add-fill"></i></span>Create Folder
                            </button>
                        @endcan
                        @can('media-delete')
                            <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#upload-image-modal"><span><i
                                        class="ri-upload-2-line"></i></span>Upload Image
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="media-container row"> @can('media-list')
                        @foreach ($mediaItems as $item)
                            <div class="media-item col-auto"> @if ($item->type == 'folder')
                                    <a href="{{ route('media.showFolder', $item->id) }}" class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="folder-icon">
                                            <i class="ri-folder-line"></i>
                                        </div>
                                        <div class="folder-name">
                                            {{ $item->name }}
                                        </div>
                                    </a>
                                @else
                                    <img src="{{ asset($item->path) }}" alt="{{ $item->name }}" class="img-fluid">
                                    <p class="text-center">{{ $item->name }}</p>
                                @endif
                                @can('media-create')
                                    <button class="delete-button" data-bs-toggle="modal"
                                            data-bs-target="#delete-modal-{{ $item->id }}">
                                        <i class="ri-delete-bin-6-fill"></i>
                                    </button>
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
                    @endcan
                </div>

                @can('media-create')
                    <div id="create-folder-modal" class="modal fade" tabindex="-1" role="dialog"
                         aria-labelledby="create-folder-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="create-folder-modalLabel">Create Folder</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('media.createFolder') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="folder-name" class="form-label">Folder Name</label>
                                            <input type="text" class="form-control" id="folder-name" name="name"
                                                   required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('media-create')
                    <div id="upload-image-modal" class="modal fade" tabindex="-1" role="dialog"
                         aria-labelledby="upload-image-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="upload-image-modalLabel">Upload Image</h4>
                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('media.uploadImage') }}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="image-file" class="form-label">Select Image</label>
                                            <input type="file" class="form-control" id="image-file" name="image"
                                                   required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
