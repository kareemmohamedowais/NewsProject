@extends('layouts.dashboard.app')
@section('title')
    categories
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories Managment</h6>
            </div>

            @include('dashboard.categories.filter.filter')
            @can('create_category')
                <div class="col-4">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-category">
                            Create Category
                        </button>
                    </div>
                </div>
            @endcan

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- table data --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $category->posts_count }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        @can('delete_category')
                                            <a href="javascript:void(0)"
                                                onclick="if(confirm('Do you want to delete the category')){document.getElementById('delete_category_{{ $category->id }}').submit()} return false"><i
                                                    class="fa fa-trash"></i></a>
                                        @endcan
                                        @can('change_status_category')
                                            <a href="{{ route('admin.category.changeStatus', $category->id) }}"><i
                                                    class="fa @if ($category->status == 1) fa-stop @else fa-play @endif"></i></a>
                                        @endcan
                                        @can('edit_category')
                                            <a href="javascript:void(0)"><i class="fa fa-edit" data-toggle="modal"
                                                    data-target="#edit-category-{{ $category->id }}"></i></a>
                                        @endcan
                                    </td>
                                </tr>

                                @can('delete_category')
 <form id="delete_category_{{ $category->id }}"
                                    action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan


                                {{-- edit Category modal --}}
                                @can('edit_category')

                                @include('dashboard.categories.edit')
                                @endcan
                                {{-- end edit category modal --}}
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No categories</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->appends(request()->input())->links() }}
                </div>

            </div>
        </div>

        {{-- modal add new category --}}
        @can('create_category')

        @include('dashboard.categories.create')
        @endcan
    </div>
    <!-- /.container-fluid -->
@endsection
