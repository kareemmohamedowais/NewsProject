    <!-- Footer Start -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3 class="title">Get in Touch</h3>
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker"></i> {{ $getSetting->street }} , {{ $getSetting->city }}, {{ $getSetting->country }}</p>
                            <p><i class="fa fa-envelope"></i>{{ $getSetting->email }}</p>
                            <p><i class="fa fa-phone"></i>{{ $getSetting->phone }}</p>
                            <div class="social">
 <a href="{{ $getSetting->twitter }}"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $getSetting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $getSetting->instagram }}"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $getSetting->youtube }}"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3 class="title">Useful Links</h3>
                        <ul>
                            @foreach ($related_sites as $related_site)

                            <li><a href="{{ $related_site->url }}">{{ $related_site->name }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3 class="title">Quick Links</h3>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">Home</a></li>
                            <li><a href="{{ route('frontend.contact.index') }}">Contact-Us</a></li>
                            @if (Auth::check())
                            <li><a href="{{ route('frontend.dashboard.profile') }}">Dashboard</a></li>
                            @endif
                            {{-- <li><a href="#">Vestibulum sit amet</a></li> --}}
                            {{-- <li><a href="#">Nam dignissim</a></li> --}}
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3 class="title">Newsletter</h3>
                        <div class="newsletter">
                            <p>
                                {{ $getSetting->small_desc }}
                            </p>
                            <form action="{{ route('frontend.news.subscribe') }}" method="POST">
                                @csrf
                                <input class="form-control" type="email" name="email" placeholder="Your email here" />
                                <button class="btn">Submit</button>
                            </form>
                            @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Footer Menu Start -->
    {{-- <div class="footer-menu">
        <div class="container">
            <div class="f-menu">
                <a href="">Terms of use</a>
                <a href="">Privacy policy</a>
                <a href="">Cookies</a>
                <a href="">Accessibility help</a>
                <a href="">Advertise with us</a>
                <a href="">Contact us</a>
            </div>
        </div>
    </div> --}}
    <!-- Footer Menu End -->

    <!-- Footer Bottom Start -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>
                        <a href="{{ route('frontend.index') }}">{{ config('app.name') }}</a>   {{ date('Y') }}

                    </p>
                </div>

                <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                <div class="col-md-6 template-by">
                    <p>Designed By <a href="https://github.com/kareemmohamedowais/">Kareem Mohamed</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->
