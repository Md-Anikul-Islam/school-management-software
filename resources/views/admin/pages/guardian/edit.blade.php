@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Edit Guardian</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Guardian</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('guardian-edit')
                        <a href="{{ route('guardian.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('guardian.update', $guardian->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control" name="photo" value="{{ $guardian->photo }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Guardian Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $guardian->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="father_name" class="form-label">Father's Name</label>
                        <input type="text" class="form-control" id="father_name" name="father_name" value="{{ $guardian->father_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="mother_name" class="form-label">Mother's Name</label>
                        <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ $guardian->mother_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="father_profession" class="form-label">Father's Profession</label>
                        <input type="text" class="form-control" id="father_profession" name="father_profession" value="{{ $guardian->father_profession }}">
                    </div>
                    <div class="mb-3">
                        <label for="mother_profession" class="form-label">Mother's Profession</label>
                        <input type="text" class="form-control" id="mother_profession" name="mother_profession" value="{{ $guardian->mother_profession }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $guardian->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $guardian->phone }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ $guardian->address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <div>
                            @if($guardian->photo)
                                <img src="{{ asset('uploads/guardians/' . $guardian->photo) }}" alt="{{ $guardian->name }}"
                                     width="100" class="img-thumbnail">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $guardian->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ $guardian->password }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
