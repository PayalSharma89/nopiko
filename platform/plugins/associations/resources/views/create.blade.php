@extends('core/base::layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add New Association</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('associations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="Education">Education</option>
                        <option value="Health">Health</option>
                        <option value="Social">Social</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Activity</label>
                    <input type="text" name="activity" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Commission (%)</label>
                    <input type="number" name="commission" class="form-control" step="0.1" value="40">
                </div>

                <div class="mb-3">
                    <label class="form-label">Approval Status</label>
                    <select name="approval_status" class="form-select">
                        <option value="pending" selected>Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <!-- start Here add casuses -->
                <div class="mb-3">
                    <label class="form-label">Causes (Categories & Tags)</label>
                    <select name="causes[]" class="form-select" multiple>
                        @foreach ($categories as $id => $name)
                            <option value="category:{{ $id }}">{{ $name }} (Category)</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Hold Ctrl (Cmd on Mac) to select multiple causes.</small>
                </div>

                <!-- end Here add casuses -->

                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1">
                    <label class="form-check-label" for="status">Active</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Background</label>
                    <input type="file" name="background" class="form-control">
                </div>

                <h5>Contact Information</h5>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control">
                </div>

                <h5>Social Media</h5>

                <div class="mb-3">
                    <label class="form-label">Facebook</label>
                    <input type="url" name="facebook" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Twitter</label>
                    <input type="url" name="twitter" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Instagram</label>
                    <input type="url" name="instagram" class="form-control">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Association</button>
                    <a href="{{ route('associations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
