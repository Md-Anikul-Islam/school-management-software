@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Assign Transport Member</li>
                    </ol>
                </div>
                <h4 class="page-title">Assign Transport Member</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('transport-member-list')
                        <a href="{{ route('transport-members.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('transport-members.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $studentId }}">

                    <div class="mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="student_name" value="{{ $student->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="transport_id" class="form-label">Route Name</label>
                        <select class="form-control" id="transport_id" name="transport_id" required>
                            <option value="">Select Route</option>
                            @foreach ($transports as $transport)
                                <option value="{{ $transport->id }}">{{ $transport->route_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fare" class="form-label">Route Fare</label>
                        <input type="number" class="form-control" id="fare" name="fare" readonly required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('transport_id').addEventListener('change', function() {
            var transportId = this.value;
            fetch('/get-fare/' + transportId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('fare').value = data.fare;
                });
        });
    </script>
@endsection
