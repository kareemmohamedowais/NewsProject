@extends('layouts.dashboard.app')
@section('title')
    Edit Admin
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <form action="{{ route('admin.admins.update', $admin->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card-body shadow mb-4" style="min-width: 75ch">
            <div class="row mb-3">
                <div class="col-9">
                    <h2>Edit Admin</h2>
                </div>
                <div class="col-3 text-end">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">Back To Admins</a>
                </div>
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" name="name" value="{{ $admin->name }}" placeholder="Enter Admin Name" class="form-control">
                @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" name="username" value="{{ $admin->username }}" placeholder="Enter Admin Username" class="form-control">
                @error('username')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ $admin->email }}" placeholder="Enter Admin Email" class="form-control">
                @error('email')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control">
                    <option selected disabled>Select Status</option>
                    <option value="1" @selected($admin->status==1)>Active</option>
                    <option value="0" @selected($admin->status==0)>Not Active</option>
                </select>
                @error('status')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select id="role_id" name="role_id" class="form-control">
                    <option selected disabled>Select Role</option>
                    @forelse ($authorizations as $authorization)
                        <option value="{{ $authorization->id }}" @selected($admin->role_id == $authorization->id)>{{ $authorization->role }}</option>
                    @empty
                        <option disabled selected>No Roles</option>
                    @endforelse
                </select>
                @error('role_id')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password <small class="text-muted">(Leave blank if not changing)</small></label>
                <input id="password" type="password" name="password" placeholder="Enter Password" class="form-control">
                @error('password')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Enter Password again" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Admin</button>
        </div>
    </form>
</div>
@endsection
