@extends('admin.app')
@section('admin_content')
    <style>
        table.table-bordered.dataTable th, table.table-bordered.dataTable td {
            border-left-width: 0;
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Leave</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apply</a></li>
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
                    <div class="d-flex justify-content-between">
                        <div class="btn-group">
                            <button style="background-color:darkblue;" class="btn text-nowrap text-light"
                                    onclick="exportTableToPDF('leave_application.pdf', '{{ $pageTitle }}')">
                                Export As PDF
                            </button>
                            <button style="background-color: darkgreen" class="btn btn-info text-nowrap"
                                    onclick="exportTableToCSV('leave_application.csv')">
                                Export To CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-bordered table-striped dt-responsive w-100">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Application To</th>
                        <th>Leave Category</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Attachment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($leaveApplications as $leaveApplication)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            @if($leaveApplication->role_id == 1)
                                <td>Student</td>
                            @else
                                <td>Teacher</td>
                            @endif
                            <td>{{ $leaveApplication->applicationTo->name }}</td>
                            <td>{{ $leaveApplication->leaveCategory->category }}</td>
                            <td>{{ $leaveApplication->start_date }}</td>
                            <td>{{ $leaveApplication->end_date }}</td>
                            <td>{!! $leaveApplication->reason !!}</td>
                            <td>
                                @if($leaveApplication->attachment)
                                    <a href="{{ asset('uploads/leave-apply/' . $leaveApplication->attachment) }}"
                                       class="btn btn-success"
                                       download>
                                        <i class="ri-download-line"></i> Download
                                    </a>
                                @else
                                    No Attachment
                                @endif
                            </td>
                            <td>
                                @if($leaveApplication->status === null)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($leaveApplication->status == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($leaveApplication->status == 2)
                                    <span class="badge bg-danger">Declined</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('leave-application.show', $leaveApplication->id) }}" class="btn btn-primary btn-sm"><i class="ri-eye-line"></i></a>
                                @if($leaveApplication->status === null)
                                    <form
                                        action="{{ route('leave-application.approve', ['id' => $leaveApplication->id, 'status' => 'approved']) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm"><i
                                                class="ri-check-line"></i></button>
                                    </form>
                                    <form
                                        action="{{ route('leave-application.decline', ['id' => $leaveApplication->id, 'status' => 'declined']) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="ri-close-line"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Excel Print
        function downloadCSV(csv, filename) {
            let csvFile;
            let downloadLink;
            // CSV file
            csvFile = new Blob([csv], {
                type: "text/csv"
            });
            // Download link
            downloadLink = document.createElement("a");
            // File name
            downloadLink.download = filename;
            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);
            // Hide download link
            downloadLink.style.display = "none";
            // Add the link to DOM
            document.body.appendChild(downloadLink);
            // Click download link
            downloadLink.click();
        }

        function exportTableToCSV(filename) {
            let csv = [];
            let rows = document.querySelectorAll("table tr");
            for (let i = 0; i < rows.length; i++) {
                let row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length - 2; j++)
                    row.push("\"" + cols[j].innerText + "\"");
                csv.push(row.join(","));
            }
            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script>
        function exportTableToPDF(filename, heading) { // Added 'heading' parameter
            const {jsPDF} = window.jspdf;
            const doc = new jsPDF();

            // Add the heading
            doc.text(heading, doc.internal.pageSize.getWidth() / 2, 20, {align: 'center'}); // Centered heading

            let rows = document.querySelectorAll("table tr");
            let data = [];
            for (let i = 0; i < rows.length; i++) {
                let row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length - 2; j++)
                    row.push(cols[j].innerText);
                data.push(row);
            }
            doc.autoTable({
                head: [data[0]],
                body: data.slice(1),
                startY: 30 // Start the table below the heading
            });
            doc.save(filename);
        }
    </script>
@endsection
