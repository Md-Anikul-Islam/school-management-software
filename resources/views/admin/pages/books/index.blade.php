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
                <div class="d-flex justify-content-between">
                    @can('books-create')
                        <a href="{{ route('books.create') }}" class="btn btn-primary">
                            <i class="ri-add-fill"></i> Add Book
                        </a>
                    @endcan
                    <div class="d-flex justify-content-between">
                        <div class="btn-group">
                            <button style="background-color:darkblue;" class="btn text-nowrap text-light"
                                    onclick="exportTableToPDF('books.pdf', '{{ $pageTitle }}')">
                                Export As PDF
                            </button>
                            <button style="background-color: darkgreen" class="btn btn-info text-nowrap"
                                    onclick="exportTableToCSV('books.csv')">
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
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Subject Code</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Rack No.</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $book->name }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->subject_code }}</td>
                            <td>{{ $book->price }}</td>
                            <td>{{ $book->quantity }}</td>
                            <td>{{ $book->rack_no }}</td>
                            <td>
                                @if ($book->status == 1)
                                    <span class="badge bg-success fs-5 py-1 px-2">Available</span>
                                @else
                                    <span class="badge bg-danger fs-5 py-1 px-2">Not Available</span>
                                @endif
                            </td>

                            <td>
                                @can('books-edit')
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-info"><i
                                            class="ri-edit-line"></i></a>
                                @endcan
                                @can('books-delete')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete-book-modal-{{ $book->id }}">
                                        <i class="ri-delete-bin-6-fill"></i>
                                    </button>
                                    <div class="modal fade" id="delete-book-modal-{{ $book->id }}" tabindex="-1"
                                         role="dialog" aria-labelledby="delete-book-modalLabel-{{ $book->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-danger">
                                                    <h4 class="modal-title"
                                                        id="delete-book-modalLabel-{{ $book->id }}">Delete Book</h4>
                                                    <button type="button" class="btn btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mt-0">Are you sure you want to delete the book "{{ $book->name }}"?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                          class="d-inline">
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
                            <td colspan="8" class="text-center">No books found.</td>
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
        function exportTableToPDF(filename, heading) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text(heading, doc.internal.pageSize.getWidth() / 2, 20, { align: 'center' });
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
                startY: 30
            });
            doc.save(filename);
        }
    </script>
@endsection
