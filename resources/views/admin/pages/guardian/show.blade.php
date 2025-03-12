@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Guardian Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Guardian Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('guardian-create')
                        <a href="{{ route('guardian.index') }}" class="btn btn-primary"><span><i
                                    class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                    <a href="{{ route('guardian.profilePdf', $guardian->id) }}" class="btn btn-primary">Download Profile
                        (PDF)</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="guardianTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="true">Profile
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="children-tab" data-bs-toggle="tab" data-bs-target="#children"
                                type="button" role="tab" aria-controls="children" aria-selected="false">Children
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="document-tab" data-bs-toggle="tab" data-bs-target="#document"
                                type="button" role="tab" aria-controls="document" aria-selected="false">Document
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="guardianTabsContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($guardian->photo)
                                    <img src="{{ asset('uploads/guardians/' . $guardian->photo) }}"
                                         alt="{{ $guardian->name }}" class="img-thumbnail" width="150">
                                @else
                                    <p>No Image</p>
                                @endif
                                <h4 class="mt-3">{{ $guardian->name }}</h4>
                                <p class="text-muted">{{ $guardian->designation }}</p>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Father's Name</th>
                                        <td>{{ $guardian->father_name }}</td>
                                        <th>Mother's Name</th>
                                        <td>{{ $guardian->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Father's Profession</th>
                                        <td>{{ $guardian->father_profession }}</td>
                                        <th>Mother's Profession</th>
                                        <td>{{ $guardian->mother_profession }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $guardian->email }}</td>
                                        <th>Phone</th>
                                        <td>{{ $guardian->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td colspan="3">{{ $guardian->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>{{ $guardian->username }}</td>
                                        <th>Status</th>
                                        <td>{{ $guardian->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="children" role="tabpanel" aria-labelledby="children-tab">
                        @if($guardian->students)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $guardian->students->name }}</td>
                                    <td>{{ $guardian->students->class }}</td>
                                    <td>{{ $guardian->students->section }}</td>
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <p>No children associated with this guardian.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#documentUploadModal">Add Document
                        </button>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($documents as $document)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $document->title }}</td>
                                    <td>{{ $document->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('guardian.downloadDocument', $document->id) }}"
                                           class="btn btn-primary btn-sm">Download</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="documentUploadModal" tabindex="-1" aria-labelledby="documentUploadModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentUploadModalLabel">Document Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardian.uploadDocument', ['id' => $guardian->id]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">File *</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
