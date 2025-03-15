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
                        <li class="breadcrumb-item active">Student List</li>
                    </ol>
                </div>
                <h4 class="page-title">Student List</h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @can('student-create')
                        <a href="{{ route('student.create') }}" class="btn btn-primary">
                            <span><i class="ri-add-fill"></i></span> Add Student
                        </a>
                    @endcan
                    <div class="d-flex justify-content-between">
                        <div class="btn-group">
                            <button style="background-color:darkblue;" class="btn text-nowrap text-light"
                                    onclick="exportTableToPDF('student.pdf')">
                                Export As PDF
                            </button>
                            <button style="background-color: darkgreen" class="btn btn-info text-nowrap"
                                    onclick="exportTableToCSV('student.csv')">
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
                        <th>Roll Number</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Guardian</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($student->photo)
                                    <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="Photo"
                                         class="img-thumbnail" width="50">
                                @else
                                    <img src="{{ asset('default-avatar.png') }}" alt="No Image"
                                         class="img-thumbnail" width="50">
                                @endif
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->roll }}</td>
                            <td>{{ $student->class->name }}</td>
                            <td>{{ $student->section->name }}</td>
                            <td>{{ ucfirst($student->gender) }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->guardian_name }}</td>
                            <td>
                                @can('student-edit')
                                    <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                @endcan
                                @can('student-delete')
                                    <a class="btn btn-danger" data-bs-toggle="modal"
                                       data-bs-target="#deleteModal{{ $student->id }}">
                                        <i class="ri-delete-bin-6-fill"></i>
                                    </a>
                                    <div id="deleteModal{{ $student->id }}" class="modal fade" tabindex="-1"
                                         role="dialog" aria-labelledby="deleteModalLabel{{ $student->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-danger">
                                                    <h4 class="modal-title"
                                                        id="deleteModalLabel{{ $student->id }}">Delete Student</h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mt-0">Are you sure you want to delete this student?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <form action="{{ route('student.destroy', $student->id) }}"
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
                            <td colspan="10" class="text-center">No students found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function downloadCSV(csv, filename) {
            let csvFile = new Blob([csv], { type: "text/csv" });
            let downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
        }

        function exportTableToCSV(filename) {
            let csv = [];
            let rows = document.querySelectorAll("table tr");
            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length - 1; j++)
                    row.push("\"" + cols[j].innerText + "\"");
                csv.push(row.join(","));
            }
            downloadCSV(csv.join("\n"), filename);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script>
        function exportTableToPDF(filename) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            let rows = document.querySelectorAll("table tr");
            let data = [];
            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length - 1; j++)
                    row.push(cols[j].innerText);
                data.push(row);
            }
            doc.autoTable({
                head: [data[0]],
                body: data.slice(1)
            });
            doc.save(filename);
        }
    </script>
@endsection
