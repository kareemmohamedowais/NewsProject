    @extends('layouts.frontend.app')

    @section('title')
    {{ $category->name }}
    @endsection

@section('breadcrumb')
@parent
    <li  class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

    @section('body')
    <br><br><br>
        <div class="main-news">
        <div class="container">
            <div class="row">
            <div class="col-lg-9">
                <div class="row">
                @forelse ($posts as $post)
    <div class="col-md-4">
        <div class="mn-img">
            <img src="{{ asset((optional($post->images->first())->path ?? 'default.jpg')) }}" alt="{{ $post->title }}" />
            <div class="mn-title">
                <a href="{{ route('frontend.post.show', $post->slug) }}" title="{{ $post->title }}">
                    {{ $post->title }}
                </a>
            </div>
        </div>
    </div>
@empty
    <p>No posts found</p>
@endforelse



                </div>
                {{ $posts->links() }}
            </div>

            <div class="col-lg-3">
                <div class="mn-list">
                <h2>Categories</h2>
                <ul>
                    @foreach ($categories as $category )

                    <li><a href="{{ route('frontend.category.posts',$category->slug) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
                </div>
            </div>
            </div>
        </div>
        </div>
    @endsection
