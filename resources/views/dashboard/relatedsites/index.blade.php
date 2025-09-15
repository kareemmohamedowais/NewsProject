@extends('layouts.dashboard.app')
@section('title')
    R-Sites
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Related Sites</h1>
        @if ($errors->any())
            <div class="alert alert-danger -ml-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Related Sites Managment</h6>
            </div>



            {{-- table data --}}
            <div class="card-body">
                @can('create_rellated_site')
                    <a href="{{ route('admin.admins.changeStatus', $admin->id) }}"><i
                            class="fa @if ($admin->status == 1) fa-stop @else fa-play @endif"></i></a>
                @endcan
                <br><br>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($sites as $site)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $site->name }}</td>
                                    <td>{{ $site->url }}</td>
                                    <td>
                                        @can('delete_rellated_site')
                                            <a href="javascript:void(0)"
                                                onclick="if(confirm('Do you want to delete the site')){document.getElementById('delete_site_{{ $site->id }}').submit()} return false"><i
                                                    class="fa fa-trash"></i></a>
                                        @endcan

                                        @can('edit_rellated_site')
                                            <a href="javascript:void(0)"><i class="fa fa-edit" data-toggle="modal"
                                                    data-target="#edit-site-{{ $site->id }}"></i></a>
                                        @endcan
                                    </td>
                                </tr>

                                @can('delete_rellated_site')
                                    <form id="delete_site_{{ $site->id }}"
                                        action="{{ route('admin.related-site.destroy', $site->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan

                                {{-- edit site modal --}}
                                @can('edit_rellated_site')
                                    @include('dashboard.relatedsites.edit')
                                @endcan
                                {{-- end edit site modal --}}
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No Sites</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $sites->links() }}
                </div>

            </div>
        </div>

        {{-- modal add new site --}}
        @can('create_rellated_site')
            @include('dashboard.relatedsites.create')
        @endcan
    </div>
    <!-- /.container-fluid -->
@endsection
