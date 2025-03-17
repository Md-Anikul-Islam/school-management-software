@extends('admin.app')

@section('admin_content')

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px; /* Same as Bootstrap .form-control */
            border: 1px solid #ced4da; /* Same as Bootstrap input border */
            border-radius: 5px; /* Rounded corners */
            padding: 6px 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px; /* Align text properly */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px; /* Align arrow with input */
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Add Student</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Student</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('student-list')
                        <a href="{{ route('student.index') }}" class="btn btn-primary">
                            <span><i class="ri-arrow-go-back-line"></i></span> Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="guardian" class="form-label">Guardian</label>
                                <select class="form-control select2" id="guardian_id" name="guardian_id" required>
                                    @if(!empty($guardians))
                                        @foreach($guardians as $guardian)
                                            <option value="{{ $guardian->id }}" {{ old('guardian') == $guardian->id ? 'selected' : '' }}>
                                                {{ $guardian->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Guardians Available.</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="admission_date">Admission Date</label>
                                <input type="date" class="form-control" id="admission_date" name="admission_date" value="{{ old('admission_date') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="admission_date">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                                    <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Female</option>
                                    <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="gender">Blood Group</label>
                                <select class="form-control" id="blood_group_id" name="blood_group_id" required>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $blood_group)
                                        <option value="{{ $blood_group }}" {{ old('blood_group_id') == $blood_group ? 'selected' : '' }}>{{ $blood_group }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="className" class="form-label">Class</label>
                                <select class="form-control select2" id="className" name="className" required>
                                    @if(!empty($classNames))
                                        @foreach($classNames as $className)
                                            <option value="{{ $className->id }}" >{{ $className->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No Class Available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control select2" id="section" name="section" required>
                                    @if(!empty($sections))
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No Section Available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="group" class="form-label">Group</label>
                                <select class="form-control select2" id="group" name="group">
                                    @if(!empty($groups))
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No Groups Available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="optional_subject" class="form-label">Optional Subject</label>
                                <select class="form-control select2" id="optional_subject_id" name="optional_subject_id" required>
                                    @if(!empty($subjects))
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No Subjects Available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="reg_no" class="form-label">Registration No.</label>
                                <input type="text" class="form-control" id="reg_no" name="reg_no" value="{{ old('reg_no') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="roll" class="form-label">Roll</label>
                                <input type="text" class="form-control" id="roll" name="roll" value="{{ old('roll') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="extra_curricular_activities" class="form-label">Extra Curricular Activities</label>
                                <textarea name="extra_curricular_activities" id="extra_curricular_activities" class="form-control">
                                    {{ old('extra_curricular_activities') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks">
                                    {{ old('remarks') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            if (typeof $.fn.select2 !== "undefined") {
                $('.select2').select2();
            } else {
                console.error("Select2 not loaded");
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('#extra_curricular_activities, #remarks').forEach(textarea => {
                ClassicEditor
                    .create(textarea)
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>

@endsection
