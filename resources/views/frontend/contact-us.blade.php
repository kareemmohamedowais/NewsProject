@extends('layouts.frontend.app')

@section('body')
    {{-- <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End --> --}}
    <br>
    <br>
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form method="POST" action="{{ route('frontend.contact.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" />
                                    <strong class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" />
                                    <strong class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </strong>

                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="phone" />

                                <strong class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" placeholder="Subject" />
                            <strong class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div class="form-group">

                                <textarea class="form-control" name="body" rows="5" placeholder="Message"></textarea>
                            <strong class="text-danger">
                                    @error('body')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.
                        </p>
                        <h4><i class="fa fa-map-marker"></i>{{ $getSetting->street }}, {{ $getSetting->city }},
                            {{ $getSetting->country }}</h4>
                        <h4><i class="fa fa-envelope"></i>{{ $getSetting->email }}</h4>
                        <h4><i class="fa fa-phone"></i>{{ $getSetting->phone }}</h4>
                        <div class="social">
                            <a href="{{ $getSetting->twitter }}"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $getSetting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $getSetting->instagram }}"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $getSetting->youtube }}"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
