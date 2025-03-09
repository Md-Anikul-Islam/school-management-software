@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Teacher Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Teacher Details</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('teacher-create')
                        <a href="{{ route('teacher.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="teacherTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="routine-tab" data-bs-toggle="tab" data-bs-target="#routine" type="button" role="tab" aria-controls="routine" aria-selected="false">Routine</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="document-tab" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab" aria-controls="document" aria-selected="false">Document</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="teacherTabsContent">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($teacher->photo)
                                    <img src="{{ asset('uploads/teachers/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="img-thumbnail" width="150">
                                @else
                                    <p>No Image</p>
                                @endif
                                <h4 class="mt-3">{{ $teacher->name }}</h4>
                                <p class="text-muted">{{ $teacher->designation }}</p>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Joining Date</th>
                                        <td>{{ $teacher->joining_date }}</td>
                                        <th>Religion</th>
                                        <td>{{ $teacher->religion }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $teacher->email }}</td>
                                        <th>Address</th>
                                        <td>{{ $teacher->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $teacher->gender }}</td>
                                        <th>Phone</th>
                                        <td>{{ $teacher->phone }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Routine Tab -->
                    <div class="tab-pane fade" id="routine" role="tabpanel" aria-labelledby="routine-tab">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Day</th>
                                <th>1st Period</th>
                                <th>2nd Period</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>TUESDAY</td>
                                <td>
                                    12:00 PM - 4:00 PM<br>
                                    Subject: Science<br>
                                    Class: Two<br>
                                    Section: B<br>
                                    Room: 106
                                </td>
                                <td>
                                    2:15 PM - 5:15 PM<br>
                                    Subject: Science<br>
                                    Class: Two<br>
                                    Section: C<br>
                                    Room: 102
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Display Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Document Tab -->
                    <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#documentUploadModal">Add Document</button>
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
                                        <a href="{{ route('teacher.downloadDocument', $document->id) }}" class="btn btn-primary btn-sm">Download</a>
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

    <!-- Document Upload Modal -->
    <div class="modal fade" id="documentUploadModal" tabindex="-1" aria-labelledby="documentUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentUploadModalLabel">Document Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Traditional Laravel Form -->
                    <form action="{{ route('teacher.uploadDocument', ['id' => $teacher->id]) }}" method="POST" enctype="multipart/form-data">
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
