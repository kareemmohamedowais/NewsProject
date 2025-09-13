@extends('layouts.dashboard.app')
@section('title')
    Create Post
@endsection

@section('content')
    <center>
        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card-body shadow mb-4 col-10">
                <a  class="btn btn-primary" href="{{ route('admin.posts.index') }}">Show Posts</a>
                <br><br>
                <h2>Create New Post</h2>
                @if (session()->has('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach (session('errors')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <br><br>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">Title</label>

                            <input type="text" value="{{ @old('title') }}" name="title" placeholder="Enter Post Title"
                                class="form-control">
                            @error('title')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="small_desc">small_desc</label>
                            <textarea name="small_desc" placeholder="Enter Post Small Description" class="form-control">{{ old('small_desc') }}</textarea>
                            @error('small_desc')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea id="postContent" name="desc" placeholder="Enter Description" class="form-control">{{ old('desc') }}</textarea>
                            @error('desc')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="postImage">Post Image</label>
                            <input type="file" multiple id="postImage" name="images[]" class="form-control">
                            @error('images')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option disabled {{ old('status', $post->status ?? null) === null ? 'selected' : '' }}>
                                    Select Status
                                </option>
                                <option value="1" {{ old('status', $post->status ?? null) == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ old('status', $post->status ?? null) == '0' ? 'selected' : '' }}>
                                    Not Active</option>
                            </select>
                            @error('status')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control">
                                <option disabled {{ old('category_id', $post->category_id ?? null) ? '' : 'selected' }}>
                                    Select Category
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id ?? null) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="comment_able">Comment Able</label>
                            <select name="comment_able" class="form-control">
                                <option disabled {{ old('comment_able') === null ? 'selected' : '' }}>Select Comment Able
                                    Status</option>
                                <option value="1" {{ old('comment_able') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('comment_able') == '0' ? 'selected' : '' }}>Not Active
                                </option>
                            </select>

                            @error('comment_able')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </div>

        </form>
    </center>
@endsection

@push('js')
    <script>
        $(function() {
            $('#postImage').fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                enableResumableUpload: false,
                showUpload: false,

            });

            $('#postContent').summernote({
                height: 300,
            });
        });
    </script>
@endpush
