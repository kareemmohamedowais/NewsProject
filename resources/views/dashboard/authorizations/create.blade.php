@extends('layouts.dashboard.app')
@section('title')
    Create Role
@endsection

@section('content')
    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.authorizations.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4" style="max-width: 90ch">
            <div class="row">
                <div class="col-9">
                    <h2>Add New Role</h2>
                </div>
                <div class="col-3">
                    <a href="{{ route('admin.authorizations.index') }}" class="btn btn-primary">Back To Roles</a>
                </div>
            </div><br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="role" placeholder="Enter Role Name" class="form-control">
                            @error('role')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    @foreach (config('authorization.permissions') as  $key=>$value)
                    <div class="col-4">
                        <div class="form-group">
                                {{ $value }} : <input value="{{ $key }}" type="checkbox" name="permissions[]">
                        </div>
                    </div>
                    @endforeach
                    @error('permissions')
                                <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

               <button type="submit" class="btn btn-primary">Create New Role</button>
            </div>

        </form>
    </div>
@endsection
