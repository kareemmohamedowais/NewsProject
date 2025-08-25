@extends('layouts.frontend.app')

@section('title')
Edit Post
@endsection
@section('body')
<div class="dashboard container">
    <!-- Sidebar -->
    <aside class="col-md-3 nav-sticky dashboard-sidebar">
      <!-- User Info Section -->
      <div class="user-info text-center p-3">
        <img src="" alt="User Image" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover" />
        <h5 class="mb-0" style="color: #ff6f61"></h5>
      </div>

      <!-- Sidebar Menu -->
      <div class="list-group profile-sidebar-menu">
        <a href="" class="list-group-item list-group-item-action active menu-item" data-section="profile">
          <i class="fas fa-user"></i> Profile
        </a>
        <a href="" class="list-group-item list-group-item-action menu-item" data-section="notifications">
          <i class="fas fa-bell"></i> Notifications
        </a>
        <a href="" class="list-group-item list-group-item-action menu-item" data-section="settings">
          <i class="fas fa-cog"></i> Settings
        </a>
      </div>
    </aside>

    <!-- Main Content -->




    <div class="main-content col-md-9">
        @if ($errors->any())
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
            </div>
        @endif
        <form action="{{ route('frontend.dashboard.post.update') }}" method="post" enctype="multipart/form-data">
            @csrf
      <!-- Show/Edit Post Section -->
      <section id="posts-section" class="posts-section">
        <h2>Your Posts</h2>
        <ul class="list-unstyled user-posts">
          <!-- Example of a Post Item -->
          <li class="post-item">
            <!-- Editable Title -->
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="text" name="title" class="form-control mb-2 post-title" value="{{ $post->title }}"  />

            <!-- Editable Content -->
            <textarea id="post-desc" name="desc" class="form-control mb-2 post-content" >
                {!! $post->desc !!}
              </textarea>

            <!-- Post Images Slider -->
            <div class="tn-slider">
              <div class="slick-slider edit-slider" id="postImages">
                <!-- Existing Images -->
              </div>
            </div>

            <!-- Image Upload Input for Editing -->
            <input id="PostImages" type="file" name="images[]" class="form-control mt-2 edit-post-image" accept="image/*" multiple />

            <br>
            <!-- Editable Category Dropdown -->
            <select  name="category_id" class="form-control mb-2 post-category">
              @foreach ($categories as $category)
              <option  value="{{ $category->id }}" @selected($category->id == $post->category_id) >{{ $category->name }}</option>
              @endforeach
            </select>

            <!-- Editable Enable Comments Checkbox -->
            <div class="form-check mb-2">
              <input name="comment_able" @checked($post->comment_able == 1) class="form-check-input enable-comments"  type="checkbox" />
              <label class="form-check-label">
                Enable Comments
              </label>
            </div>

            <!-- Post Meta: Views and Comments -->
            <div class="post-meta d-flex justify-content-between">
              <span class="views">
                <i class="bi bi-eye-fill"></i> {{ $post->num_of_views }}
              </span>

              <span class="post-comments">
                <i class="bi bi-chat"></i>{{ $post->comments->count() }}
              </span>
            </div>

            <!-- Post Actions -->
            <div class="post-actions mt-2">
              <button class="btn btn-primary edit-post-btn">Edit</button>
              <a href="" class="btn btn-danger delete-post-btn">Delete</a>
              <button type="submit" class="btn btn-success save-post-btn d-none">
                Save
              </button>
              <a href="{{ route('frontend.dashboard.profile') }}" class="btn btn-secondary cancel-edit-btn d-none">
                Cancel
              </a>
            </div>

          </li>
          <!-- Additional posts will be added dynamically -->
        </ul>
      </section>
    </form>
    </div>
  </div>

@endsection

@push('js')
<script>
    $('#PostImages').fileinput({
        theme: 'fa5',
            allowedFileTypes: ['image'],
            maxFileCount: 5,
            enableResumableUpload: false,
            showUpload: false,
            initialPreviewAsData: true,
            initialPreview: [
                @if ($post->images->count() > 0)
                    @foreach ($post->images as $image)
                        "{{ asset($image->path) }}",
                    @endforeach
                @endif
            ],
            initialPreviewConfig: [
                @if($post->images->count() > 0)
                    @foreach ($post->images as $image)
                        {
                            caption: "{{ $image->path }}",
                            width: '120px',
                            url: "{{ route('frontend.dashboard.post.image.delete' , [$image->id , '_token'=>csrf_token()]) }}",
                            key: "{{ $image->id }}",

                        },
                    @endforeach
            @endif
        ]

    });
    $('#post-desc').summernote({
            height: 300,
        });
</script>
@endpush
