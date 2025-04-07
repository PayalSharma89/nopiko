@extends('core/base::layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Association</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('associations.update', $association->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $association->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ $association->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="Education" {{ $association->type == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Health" {{ $association->type == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Social" {{ $association->type == 'Social' ? 'selected' : '' }}>Social</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Activity</label>
                    <input type="text" name="activity" class="form-control" value="{{ $association->activity }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ $association->location }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ $association->address }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Commission (%)</label>
                    <input type="number" name="commission" class="form-control" step="0.1" value="{{ $association->commission }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Approval Status</label>
                    <select name="approval_status" class="form-select">
                        <option value="pending" {{ $association->approval_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $association->approval_status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $association->approval_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Causes (Categories)</label>
                    <select name="causes[]" class="form-select" multiple>
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" {{ in_array($id, $selectedCauses) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ $association->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control">
                    @if($association->image)
                        <img src="{{ asset('storage/' . $association->image) }}" alt="Association Image" class="mt-2 rounded" width="100">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Background</label>
                    <input type="file" name="background" class="form-control">
                    @if($association->background)
                        <img src="{{ asset('storage/' . $association->background) }}" alt="Background Image" class="mt-2 rounded" width="100">
                    @endif
                </div>

                <h5>Contact Information</h5>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $association->email }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $association->phone }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control" value="{{ $association->website }}">
                </div>

                <h5>Social Media</h5>

                <div class="mb-3">
                    <label class="form-label">Facebook</label>
                    <input type="url" name="facebook" class="form-control" value="{{ $association->facebook }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Twitter</label>
                    <input type="url" name="twitter" class="form-control" value="{{ $association->twitter }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Instagram</label>
                    <input type="url" name="instagram" class="form-control" value="{{ $association->instagram }}">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Association</button>
                    <a href="{{ route('associations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
