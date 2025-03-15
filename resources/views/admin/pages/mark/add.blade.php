@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Add Mark</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Mark</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('mark-list')
                        <a href="{{ route('mark.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('mark.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-control" id="class" name="class" required>
                                    @if(empty($classes))
                                        <option value="">No Class Available</option>
                                    @else
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exam" class="form-label">Exam</label>
                                <select class="form-control" id="exam" name="exam" required>
                                    @if(empty($exams))
                                        <option value="">No Exam Available</option>
                                    @else
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control" id="section" name="section" required>
                                    @if(empty($sections))
                                        <option value="">No Section Available</option>
                                    @else
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-control" id="subject" name="subject" required>
                                    @if(empty($subjects))
                                        <option value="">No Subject Available</option>
                                    @else
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
