@extends('core/base::layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Associations Management</h4>
            <div>
                <a href="{{ route('associations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Association
                </a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importJsonModal">
                    <i class="fas fa-upload"></i> Import JSON
                </button>  
            </div>
        </div>
        
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Commission (%)</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($associations as $association)
                        <tr>
                            <td>{{ $association->id }}</td>
                            <td>{{ $association->name }}</td>
                            <td>{{ Str::limit($association->description, 50) }}</td>
                            <td>{{ $association->type }}</td>
                            <td>{{ $association->location }}</td>
                            <td>{{ $association->commission }}%</td>
                            <td>
                                <input type="checkbox" class="toggle-status" data-id="{{ $association->id }}"
                                    {{ $association->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @if($association->approval_status === 'pending')
                                <form action="{{ route('associations.approve', $association->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>

                                <form action="{{ route('associations.reject', $association->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>

                                @else
                                    <span class="badge {{ $association->approval_status === 'approved' ? 'bg-primary' : 'bg-warning' }}">
                                        {{ ucfirst($association->approval_status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('associations.edit', $association->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('associations.delete', $association->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- JSON Import Modal -->
    <div class="modal fade" id="importJsonModal" tabindex="-1" aria-labelledby="importJsonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importJsonModalLabel">Import Associations (JSON)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importJsonForm" action="{{ route('associations.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="json_file" class="form-control" accept=".json" required>
                        <br>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Toggle Status -->
    <script>
        $(document).ready(function () {
            $('.toggle-status').change(function () {
                let associationId = $(this).data('id');
                let newStatus = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route("associations.update.status") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: associationId,
                        status: newStatus
                    },
                    success: function (response) {
                        alert(response.message);
                    },
                    error: function () {
                        alert('Error updating status');
                    }
                });
            });
        });
    </script>
@endsection
