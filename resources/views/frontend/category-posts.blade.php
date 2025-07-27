    @extends('layouts.frontend.app')

    @section('body')
    <br><br><br>
        <div class="main-news">
        <div class="container">
            <div class="row">
            <div class="col-lg-9">
                <div class="row">
                @forelse ($posts as $post )

                <div class="col-md-4">
                    <div class="mn-img">
                    <img src="{{ asset('assets/frontend') }}/{{ $post->images->first()->path }}" />
                    <div class="mn-title">
                        <a href="" title="{{ $post->title }}">{{ $post->title }}</a>
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
