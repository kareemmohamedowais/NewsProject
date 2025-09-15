    @extends('layouts.dashboard.app')
    @section('title')
        Posts
    @endsection
    @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Posts Managment</h6>
                </div>

                @include('dashboard.posts.filter.filter')
                <div class="col-4">
                    @can('create_post')
                        <div class="form-group">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                Create Post
                            </a>
                        </div>
                    @endcan
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>title</th>
                                    <th>Category</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>title</th>
                                    <th>Category</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td>{{ $post->user?->name ?? ($post->admin?->name ?? 'غير معروف') }}</td>
                                        <td>{{ $post->status == 1 ? 'Active' : 'Not Active' }}</td>
                                        <td>{{ $post->num_of_views }}</td>
                                        <td>
                                            @can('delete_post')
                                                <a href="javascript:void(0)"
                                                    onclick="if(confirm('Do you want to delete the post')){document.getElementById('delete_post_{{ $post->id }}').submit()} return false"><i
                                                        class="fa fa-trash"></i></a>
                                            @endcan
                                            @can('change_status_post')
                                                <a href="{{ route('admin.posts.changeStatus', $post->id) }}"><i
                                                        class="fa @if ($post->status == 1) fa-stop @else fa-play @endif"></i></a>
                                            @endcan
                                            @can('show_post')
                                                <a
                                                    href="{{ route('admin.posts.show', ['post' => $post->id, 'page' => request()->page]) }}"><i
                                                        class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('edit_post')
                                                @if ($post->user_id == null)
                                                    <a href="{{ route('admin.posts.edit', $post->id) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>

                                    @can('delete_post')
                                        <form id="delete_post_{{ $post->id }}"
                                            action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                @empty
                                    <tr>
                                        <tdv class="alert alert-info" colspan="6"> No posts</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $posts->appends(request()->input())->links() }}
                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    @endsection
