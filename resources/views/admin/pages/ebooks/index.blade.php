@extends('admin.app')
@section('admin_content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Ebooks</li>
                    </ol>
                </div>
                <h4 class="page-title">Ebooks</h4>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            @can('ebooks-create')
                <a href="{{ route('ebooks.create') }}" class="btn btn-info mb-2"><i class="ri-add-line me-1"></i> Add
                    Ebook</a>
            @endcan
        </div>
    </div>

    <div class="row">
        @forelse ($ebooks as $ebook)
            <div class="col-md-3 mb-3 ebook-item">
                <div class="card shadow-sm">
                    <div class="card-body position-relative overflow-hidden p-2"
                         style="height: 250px; display: flex; align-items: center; justify-content: center;">
                        @can('ebooks-view')
                            <a href="{{ route('ebooks.view', $ebook->id) }}" class="ebook-cover-link" target="_blank">
                                <img src="{{ asset('uploads/ebooks/' . $ebook->cover_photo) }}"
                                     alt="{{ $ebook->name }}"
                                     class="img-fluid rounded"
                                     style="width: 100%; display: block; object-fit: cover; height: 200px;"> {{-- Adjust height as needed --}}
                            </a>
                        @endcan
                        <div
                            class="ebook-actions position-absolute top-0 end-0 bg-dark bg-opacity-75 p-2 d-flex flex-column">
                            @can('ebooks-edit')
                                <a href="{{ route('ebooks.edit', $ebook->id) }}"
                                   class="btn btn-sm btn-primary mb-1" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </a>
                            @endcan
                            @can('ebooks-delete')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                   data-bs-target="#danger-modal-ebook-{{ $ebook->id }}" title="Delete">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                                <div id="danger-modal-ebook-{{ $ebook->id }}" class="modal fade" tabindex="-1"
                                     role="dialog" aria-labelledby="danger-header-modalLabel-ebook-{{ $ebook->id }}"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel-ebook-{{ $ebook->id }}">Delete
                                                    Ebook</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are you sure you want to delete the ebook
                                                    "{{ $ebook->name }}"?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close
                                                </button>
                                                <form action="{{ route('ebooks.destroy', $ebook->id) }}"
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
                    </div>
                    @can('ebooks-view')
                        <div class="card-body p-2 text-center">
                            <a href="{{ route('ebooks.view', $ebook->id) }}" class="ebook-cover-link" target="_blank">
                                <!-- Title -->
                                <div class="fw-bold mb-1">
                                    {{ Str::limit($ebook->name, 30) }}
                                </div>
                                <!-- Author -->
                                <div class="text-muted mb-1">
                                    <span>By</span> {{ Str::limit($ebook->author, 25) }}
                                </div>
                                <!-- Class -->
                                @if($ebook->class)
                                    <div class="text-muted">
                                        Class: {{ $ebook->class->name }}
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No ebooks found.</div>
            </div>
        @endforelse
    </div>
@endsection
