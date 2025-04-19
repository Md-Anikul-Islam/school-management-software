@extends('admin.app')
@section('admin_content')

    <style>
        .readonly-select {
            pointer-events: none;
            background-color: #e9ecef; /* Light gray to show it's disabled */
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                        <li class="breadcrumb-item active">Renew Sponsorship</li>
                    </ol>
                </div>
                <h4 class="page-title">Renew Sponsorship</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('sponsorship-list')
                        <a href="{{ route('sponsorship.index') }}" class="btn btn-primary"><span><i class="ri-arrow-go-back-line"></i></span>Back</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('sponsorship.renew_sponsorship', $sponsorship->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="candidate_id" class="form-label">Candidate</label>
                        <select class="form-select readonly-select" id="candidate_id" name="candidate_id" required>
                            <option value="{{ $sponsorship->candidate_id }}" selected>{{ $sponsorship->candidate->student->name }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sponsor_id" class="form-label">Sponsor</label>
                        <select class="form-select readonly-select" id="sponsor_id" name="sponsor_id" required>
                            <option value="{{ $sponsorship->sponsor_id }}" selected>{{ $sponsorship->sponsor->name }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $sponsorship->start_date }}" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $sponsorship->end_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="{{ $sponsorship->amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Renew</button>
                </form>
            </div>
        </div>
    </div>
@endsection
