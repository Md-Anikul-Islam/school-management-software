<div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#documentUploadModal">Add Document</button>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($documents as $document)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $document->title }}</td>
                <td>{{ $document->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-primary btn-sm" download>Download</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
