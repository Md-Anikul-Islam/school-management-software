@extends('admin.app')
@section('admin_content')
    <style>
        label {
            text-transform: capitalize;
        }

        /* Toggle switch styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px; /* Width of the switch */
            height: 23px; /* Height of the switch */
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc; /* Default background color */
            transition: 0.4s; /* Smooth transition */
            border-radius: 23px; /* Rounded corners */
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 19px; /* Height of the slider circle */
            width: 19px; /* Width of the slider circle */
            border-radius: 50%; /* Make it round */
            left: 2px; /* Initial position from the left */
            bottom: 2px; /* Initial position from the bottom */
            background-color: white; /* Color of the slider circle */
            transition: 0.4s; /* Smooth transition */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
        }

        input:checked + .slider {
            background-color: #4CAF50; /* Background color when checked */
        }

        input:checked + .slider:before {
            transform: translateX(17px); /* Move the slider circle to the right */
        }

        /* Optional: Add a focus state for accessibility */
        input:focus + .slider {
            box-shadow: 0 0 1px #4CAF50;
        }


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
                <div class="d-flex justify-content-between">
                    @can('guardian-create')
                        <a href="{{ route('guardian.create') }}" class="btn btn-primary"><span><i
                                    class="ri-add-fill"></i></span>Add Guardian</a>
                    @endcan
                    <div class="d-flex justify-content-between">
                        <div class="btn-group">
                            <button style="background-color:darkblue;" class="btn text-nowrap text-light"
                                    onclick="exportTableToPDF('guardian.pdf', 'Guardian List')">
                                Export As PDF
                            </button>
                            <button style="background-color: darkgreen" class="btn btn-info text-nowrap"
                                    onclick="exportTableToCSV('guardian.csv')">
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
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($guardians as $guardian)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if($guardian->photo)
                                    <img src="{{ asset('uploads/guardians/' . $guardian->photo) }}"
                                         alt="{{ $guardian->name }}" width="70" class="img-thumbnail">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $guardian->name }}</td>
                            <td>{{ $guardian->email }}</td>
                            @can('guardian-status')
                                <td>
                                    <form action="{{ route('guardian.update_status', $guardian->id) }}" method="POST"
                                          class="status-form">
                                        @csrf
                                        @method('PUT')
                                        <label class="switch">
                                            <input type="checkbox" name="status" value="1"
                                                   {{ $guardian->status == 1 ? 'checked' : '' }}
                                                   onchange="this.form.submit()">
                                            <span class="slider round"></span>
                                        </label>
                                    </form>
                                </td>
                            @endcan
                            <td>
                                @can('guardian-edit')
                                    <a href="{{ route('guardian.edit', $guardian->id) }}" class="btn btn-info"><i
                                            class="ri-edit-line"></i></a>
                                @endcan
                                @can('guardian-show')
                                    <a href="{{ route('guardian.show', $guardian->id) }}" class="btn btn-primary"><i
                                            class="ri-eye-fill"></i></a>
                                @endcan
                                @can('guardian-delete')
                                    <a class="btn btn-danger" data-bs-toggle="modal"
                                       data-bs-target="#danger-header-modal{{ $guardian->id }}"><i
                                            class="ri-delete-bin-6-fill"></i></a>
                                    <div id="danger-header-modal{{ $guardian->id }}" class="modal fade" tabindex="-1"
                                         role="dialog" aria-labelledby="danger-header-modalLabel{{ $guardian->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-danger">
                                                    <h4 class="modal-title"
                                                        id="danger-header-modalLabel{{ $guardian->id }}">Delete</h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mt-0">Are you sure you want to delete this guardian?</h5>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <form action="{{ route('guardian.destroy', $guardian->id) }}"
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
            doc.text(heading, doc.internal.pageSize.getWidth() / 2, 20, { align: 'center' }); // Centered heading

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
