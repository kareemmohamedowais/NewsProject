@extends('layouts.frontend.app')

@section('title')
    Search
@endsection

@section('body')
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

                        @foreach ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ asset(optional($post->images->first())->path ?? 'default.jpg') }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                {{ $posts->links() }}


            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
