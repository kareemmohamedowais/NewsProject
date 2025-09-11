@extends('layouts.dashboard.app')
@section('title')
    Create User
@endsection

@section('content')
<center>
    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="card-body shadow mb-4 col-10">
            <a  class="btn btn-primary" href="{{ route('admin.users.index') }}">Show Users</a>
                <br><br>
            <h2>Create New User</h2><br><br>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter User Name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter Username" class="form-control" value="{{ old('username') }}">
                        @error('username')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter Phone Number" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option selected disabled>Select Status</option>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Not Active</option>
                        </select>
                        @error('status')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="email_verified_at">Email Verified</label>
                        <select name="email_verified_at" id="email_verified_at" class="form-control">
                            <option selected disabled>Select Email Status</option>
                            <option value="1" {{ old('email_verified_at') == '1' ? 'selected' : '' }}>Verified</option>
                            <option value="0" {{ old('email_verified_at') == '0' ? 'selected' : '' }}>Not Verified</option>
                        </select>
                        @error('email_verified_at')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" placeholder="Enter Country" class="form-control" value="{{ old('country') }}">
                        @error('country')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" placeholder="Enter City" class="form-control" value="{{ old('city') }}">
                        @error('city')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" placeholder="Enter Street" class="form-control" value="{{ old('street') }}">
                        @error('street')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                        @error('image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                    </div>
                </div>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>
    </form>
</center>
@endsection
