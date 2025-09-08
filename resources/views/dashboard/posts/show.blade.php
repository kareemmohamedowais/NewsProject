@extends('layouts.dashboard.app')
@section('title')
    show User
@endsection

@push('css')
   {{-- toastr notification --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="d-flex justify-content-center">
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <a class="btn btn-primary" href="{{ route('admin.posts.index', ['page' => request()->page]) }}">Back To Posts</a>
            <br><br>
            <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#newsCarousel" data-slide-to="1"></li>
                    <li data-target="#newsCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" style="height: 70ch">
                    @foreach ($post->images as $index => $image)
                        <div class="carousel-item @if ($index == 0) active @endif">
                            <img src="{{ asset($image->path) }}" class="d-block w-100" alt="First Slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $post->title }}</h5>
                                <p>

                                </p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Add more carousel-item blocks for additional slides -->
                </div>
                <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <br>
            <div class="row">
                <div class="col-4">
                    <h6>
                        Publisher : {{ $post->user->name ?? $post->admin->name }} <i class="fa fa-user"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Views : {{ $post->num_of_views }} <i class="fa fa-eye"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Created At : {{ $post->created_at->format('Y-m-d h:m') }} <i class="fa fa-edit"></i>
                    </h6>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <h6>
                        Comments : {{ $post->comment_able == 1 ? 'Active' : 'Not Active' }} <i class="fa fa-comment"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Status : {{ $post->status == 1 ? 'Active' : 'Not Active' }} <i
                            class="fa @if ($post->status == 0) fa-plane @else fa-wifi @endif "></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        Category : {{ $post->category->name }}   <i class="fa fa-folder"></i>
                    </h6>
                </div>
            </div>
            <br>
            <div class="sn-content">
                <strong>Small Description : {{ $post->small_desc }}</strong>
            </div>
            <br>
            <div class="sn-content">
                {!! $post->desc !!}
            </div>

            <br>
            <center>
                <a class="btn btn-danger" href="javascript:void(0)"
                    onclick="if(confirm('Do you want to delete the post')){document.getElementById('delete_post_{{ $post->id }}').submit()} return false">Delete
                    Post <i class="fa fa-trash"></i></a>
                <a class="btn btn-primary" href="{{ route('admin.posts.changeStatus', $post->id) }}">Change Status <i
                        class="fa @if ($post->status == 1) fa-stop @else fa-play @endif"></i></a>
                <a class="btn btn-info" href="{{ route('admin.posts.edit', $post->id) }}">Edit Post <i
                        class="fa fa-edit"></i></a>
            </center>
        </div>
    </div>
    <form id="delete_post_{{ $post->id }}" action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
        @csrf
        @method('DELETE')
    </form>



    {{-- show comments --}}
    <div class="d-flex justify-content-center">

        <!-- Main Content -->
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Comments</h2>
                    </div>
            <button post-id="{{ $post->id }}" id="commentbtn_{{ $post->id }}" class="getComments" class="btn btn-info btn-sm" style="margin-left: 320px">
                <i class="fas fa-comment"></i> Comments
            </button>
            <button style="display: none;margin-left: 280px;" post-id="{{ $post->id }}" id="hideCommentId_{{ $post->id }}" class="hideComments" class="btn btn-info btn-sm">
                <i class="fas fa-comment"></i> Hide Comments
            </button>

                </div>
                <div id="displayComments_{{ $post->id }}" class="comments" style="display: none;">

                            <!-- Add more comments here for demonstration -->
                </div>
                {{-- @forelse ($post->comments as $comment )
                <div class="notification alert alert-info comment-box" id="comment-{{ $comment->id }}">
                    <strong><img src="{{ asset($comment->user->image) }}" width="50px" class="img-thumbnial rounded">
                    <a style="text-decoration: none" href="{{ route('admin.users.show' , $comment->user->id) }}">{{ $comment->user->name }}</a> : </strong> {{ $comment->comment }}.<br>
                    <strong style="color: red"> {{ $comment->created_at->diffForHumans() }}</strong>
                    <div class="float-right">
                    <a href="javascript:void(0)"
   data-id="{{ $comment->id }}"
   class="btn btn-danger btn-sm delete-comment">
   Delete
</a>


                    </div>
                </div>
                @empty
                        <div class="alert alert-info">
                        No Comments yet!
                    </div>
                @endforelse --}}







            </div>
        </div>
    </div>
@endsection

@push('js')
  {{--  toastr notification --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
$(document).on('click', '.delete-comment', function(e) {
    e.preventDefault();

    let commentId = $(this).data('id');
    let commentBox = $("#comment-" + commentId); // استهدف الـ div بتاع التعليق

    // if(confirm("Are you sure you want to delete this comment?")) {
        $.ajax({
            url: "{{ route('admin.posts.deleteComment', ':id') }}".replace(':id', commentId),
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.status) {
                    // امسح التعليق من الواجهة مع تأثير
                    commentBox.fadeOut(500, function() {
                        $(this).remove();
                    });
 // Display an info toast with no title
                    toastr.success(response.msg,{timeOut: 5000})                }
            },
            error: function() {
                alert("Something went wrong while deleting the comment.");
            }
        });
    // }
});

    //     //    get post comments
    //     $(document).on('click', '.getComments', function(e) {
    //         e.preventDefault();
    //         var post_id = $(this).attr('post-id');

    //         $.ajax({
    //             type: "GET",
    //             url: '{{ route('admin.posts.getComments', ':post_id') }}'.replace(':post_id', post_id),
    //             success: function(response) {
    //                 $('#displayComments_'+post_id).empty();


    //                 $.each(response.data, function(indexInArray, comment) {
    //                     $('#displayComments_'+post_id).append(`
    //     <div class="notification alert alert-info comment-box" id="comment-${comment.id}">
    //         <strong>
    //             <img src="http://127.0.0.1:8000/uploads/${comment.user.image}" width="50px" class="img-thumbnail rounded">
    //             <a style="text-decoration: none" href="/admin/users/${comment.user.id}">
    //                 ${comment.user.name}
    //             </a> :
    //         </strong>
    //         ${comment.comment}.<br>

    //         <strong style="color: red">${comment.created_at}</strong>

    //         <div class="float-right">
    //             <a href="javascript:void(0)"
    //                data-id="${comment.id}"
    //                class="btn btn-danger btn-sm delete-comment">
    //                Delete
    //             </a>
    //         </div>
    //     </div>
    // `).show();
    //                 });
    //                 $('#commentbtn_'+post_id).hide();
    //                 $('#hideCommentId_'+post_id).show();
    //             }
    //         });

    //     });

        // hide post comments
        $(document).on('click',  '.hideComments' , function(e){
            e.preventDefault();
            var post_id = $(this).attr('post-id');

            // 1- hide comments
            $('#displayComments_'+post_id).hide();
            // 2- hide (hide comment btn)
            $('#hideCommentId_'+post_id).hide();

            // 3- Apper btn (comment)
            $('#commentbtn_'+post_id).show();

        });

// get post comments
$(document).on('click', '.getComments', function(e) {
    e.preventDefault();
    var post_id = $(this).attr('post-id');

    $.ajax({
        type: "GET",
        url: '{{ route('admin.posts.getComments', ':post_id') }}'.replace(':post_id', post_id),
        success: function(response) {
            var commentsContainer = $('#displayComments_'+post_id);
            commentsContainer.empty();

            // نخزن كل التعليقات في data attribute
            var allComments = response.data;
            commentsContainer.data('allComments', allComments);

            // نظهر أول 5 بس
            renderLimitedComments(commentsContainer, 5);

            // لو في اكتر من 5 يظهر زرار Show More
            if(allComments.length > 5){
                commentsContainer.append(`
                    <div class="text-center mt-2 toggle-buttons">
                        <button class="btn btn-link show-more" data-post="${post_id}">Show More</button>
                        <button class="btn btn-link show-less" data-post="${post_id}" style="display:none;">Show Less</button>
                    </div>
                `);
            }

            commentsContainer.show();
            $('#commentbtn_'+post_id).hide();
            $('#hideCommentId_'+post_id).show();
        }
    });
});

// زرار Show More
$(document).on('click', '.show-more', function(){
    var post_id = $(this).data('post');
    var commentsContainer = $('#displayComments_'+post_id);
    var allComments = commentsContainer.data('allComments');

    commentsContainer.find('.comment-box').remove(); // امسح القديم
    $.each(allComments, function(index, comment) {
        commentsContainer.prepend(renderComment(comment));
    });

    $(this).hide();
    commentsContainer.find('.show-less').show();
});

// زرار Show Less
$(document).on('click', '.show-less', function(){
    var post_id = $(this).data('post');
    var commentsContainer = $('#displayComments_'+post_id);

    renderLimitedComments(commentsContainer, 5);

    $(this).hide();
    commentsContainer.find('.show-more').show();
});

// دالة عرض 5 تعليقات فقط
function renderLimitedComments(container, limit){
    var allComments = container.data('allComments');
    container.find('.comment-box').remove(); // امسح القديم
    $.each(allComments.slice(0, limit), function(index, comment) {
        container.prepend(renderComment(comment));
    });
}

// دالة توليد الكومنت
function renderComment(comment){
    return `
        <div class="notification alert alert-info comment-box" id="comment-${comment.id}">
            <strong>
                <img src="${comment.user.image}" width="50px" class="img-thumbnail rounded">
                <a style="text-decoration: none" href="/admin/users/${comment.user.id}">
                    ${comment.user.name}
                </a> :
            </strong>
            ${comment.comment}.<br>
            <strong style="color: red">${comment.created_at}</strong>
            <div class="float-right">
                <a href="javascript:void(0)"
                   data-id="${comment.id}"
                   class="btn btn-danger btn-sm delete-comment">
                   Delete
                </a>
            </div>
        </div>
    `;
}

</script>






@endpush
