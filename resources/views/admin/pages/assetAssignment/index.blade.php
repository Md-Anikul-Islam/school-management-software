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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">School</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
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
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between gap-1">
                        @can('asset-assignment-create')
                            <a href="{{ route('asset-assignment.create') }}" class="btn btn-primary"><span><i
                                        class="ri-add-fill"></i></span>Add Asset Assignment</a>
                        @endcan
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <div class="btn-group">
                                <button style="background-color:darkblue;" class="btn text-nowrap text-light"
                                        onclick="exportTableToPDF('asset_assignments.pdf', '{{ $pageTitle }}')">
                                    Export As PDF
                                </button>
                                <button style="background-color: darkgreen" class="btn btn-info text-nowrap"
                                        onclick="exportTableToCSV('asset_assignments.csv')">
                                    Export To CSV
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-bordered table-striped dt-responsive w-100">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Asset</th>
                        <th>Assign Quantity</th>
                        <th>Check Out To</th>
                        <th>Due Date</th>
                        <th>Check Out Date</th>
                        <th>Check In Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($assetAssignments as $assignment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $assignment->asset->title }}</td>
                            <td>{{ $assignment->assign_quantity }}</td>
                            <td>{{ $assignment->check_out_to }}</td>
                            <td>{{ $assignment->due_date }}</td>
                            <td>{{ $assignment->check_out_date }}</td>
                            <td>{{ $assignment->check_in_date }}</td>
                            <td>{{ $assignment->location->location }}</td>
                            <td>{{ $assignment->status }}</td>
                            <td>{{ $assignment->note }}</td>
                            <td>
                                @can('asset-assignment-edit')
                                    <a href="{{ route('asset-assignment.edit', $assignment->id) }}" class="btn btn-info"><i
                                            class="ri-edit-line"></i></a>
                                @endcan
                                @can('asset-assignment-show')
                                    <a href="{{ route('asset-assignment.show', $assignment->id) }}" class="btn btn-primary"><i
                                            class="ri-eye-fill"></i></a>
                                @endcan
                                @can('asset-assignment-delete')
                                    <a class="btn btn-danger" data-bs-toggle="modal"
                                       data-bs-target="#danger-header-modal{{ $assignment->id }}"><i
                                            class="ri-delete-bin-6-fill"></i></a>
                                    <div id="danger-header-modal{{ $assignment->id }}" class="modal fade"
                                         tabindex="-1"
                                         role="dialog" aria-labelledby="danger-header-modalLabel{{ $assignment->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-danger">
                                                    <h4 class="modal-title"
                                                        id="danger-header-modalLabel{{ $assignment->id }}">Delete</h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mt-0">Are you sure you want to delete this asset assignment?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <form
                                                        action="{{ route('asset-assignment.destroy', $assignment->id) }}"
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No asset assignments found.</td>
                        </tr>
                    @endforelse
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
                for (let j = 0; j < cols.length - 1; j++)
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
            doc.text(heading, doc.internal.pageSize.getWidth() / 2, 20, { align: 'center' }); // Centered heading

            let rows = document.querySelectorAll("table tr");
            let data = [];
            for (let i = 0; i < rows.length; i++) {
                let row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length - 1; j++)
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
