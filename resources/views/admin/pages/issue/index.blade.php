@extends('admin.app')

@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Issue</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $pageTitle ?? 'Issue Search & List' }}</h4>
            </div>
        </div>
    </div>

    {{-- "Issue a book" Link --}}
    @can('issue-create')
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('issue.create') }}" class="btn btn-success">
                    <i class="ri-add-line"></i> Issue a Book
                </a>
            </div>
        </div>
    @endcan

    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title text-center">Search Issued Books by Library ID</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('issue.index') }}" method="GET" class="row gy-2 align-items-center">
                        <div class="col-9"><label for="library_id_search" class="visually-hidden">Library ID</label>
                            <input type="search" class="form-control form-control" id="library_id_search"
                                   name="library_id"
                                   placeholder="Enter Library ID *"
                                   value="{{ $searchLibraryId ?? old('library_id') }}"
                                   required>
                        </div>
                        <div class="col-auto ms-auto">
                            <button type="submit" class="btn btn-primary"><i class="ri-search-line"></i> Search
                            </button>
                            @if($searchLibraryId)
                                <a href="{{ route('issue.index') }}" class="btn btn-light ms-1">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($searchLibraryId))
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Issue Records for Library ID: {{ $searchLibraryId }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="issue-table" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Library ID</th>
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th>Serial No</th>
                                    <th>Due Date</th>
                                    <th>Issued At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($issues as $key => $issue)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $issue->library_id }}</td>
                                        <td>{{ $issue->book->name ?? 'N/A (Book Deleted?)' }}</td>
                                        <td>{{ $issue->author }}</td>
                                        <td>{{ $issue->serial_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($issue->due_date)->format('d M, Y') }}</td>
                                        <td>{{ $issue->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            @can('issue-edit')
                                                <a href="{{ route('issue.edit', $issue->id) }}"
                                                   class="btn btn-info btn-sm" title="Edit">
                                                    <i class="ri-edit-box-line"></i>
                                                </a>
                                            @endcan
                                            @can('issue-delete')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete-issue-modal-{{ $issue->id }}"
                                                        title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                                <div class="modal fade" id="delete-issue-modal-{{ $issue->id }}"
                                                     tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="delete-issue-modalLabel-{{ $issue->id }}"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header modal-colored-header bg-danger">
                                                                <h4 class="modal-title"
                                                                    id="delete-issue-modalLabel-{{ $issue->id }}">Delete
                                                                    Issue</h4>
                                                                <button type="button"
                                                                        class="btn btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="mt-0">Are you sure you want to delete this
                                                                    issue record (Library ID: {{ $issue->library_id }})?
                                                                </h5>
                                                                <p class="text-muted">This action might be irreversible
                                                                    depending on system settings.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close
                                                                </button>
                                                                <form
                                                                    action="{{ route('issue.destroy', $issue->id) }}"
                                                                    method="POST"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No issued book records found for this
                                            Library ID.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(request()->has('library_id') && empty($searchLibraryId))
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    Please enter a Library ID to search.
                </div>
            </div>
        </div>
    @endif
@endsection
