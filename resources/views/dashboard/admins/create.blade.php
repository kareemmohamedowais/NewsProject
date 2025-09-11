@extends('layouts.dashboard.app')
@section('title')
    Create Admin
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <form action="{{ route('admin.admins.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body shadow mb-4" style="min-width: 75ch">

            <div class="row">
                <div class="col-9">
                    <h2>Create New Admin</h2>
                </div>
                <div class="col-3">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">Back To Admins</a>
                </div>
            </div>
            <br>

            {{-- Name --}}
            <div class="form-group">
                <label for="name">Enter Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter Admin name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Username --}}
            <div class="form-group">
                <label for="username">Enter Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter Admin Username"
                       class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Enter Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter Admin Email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="status">Select Status:</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option disabled selected>Select Status</option>
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Not Active</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label for="role_id">Select Role:</label>
                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror">
                    <option disabled selected>Select Role</option>
                    @forelse ($authorizations as $authorization)
                        <option value="{{ $authorization->id }}" {{ old('role_id') == $authorization->id ? 'selected' : '' }}>
                            {{ $authorization->role }}
                        </option>
                    @empty
                        <option disabled selected>No Roles</option>
                    @endforelse
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Enter Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter Password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter Password again" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create Admin</button>
        </div>
    </form>
</div>
@endsection
