    <!-- Top Bar Start -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="tb-contact">
                        <p><i class="fas fa-envelope"></i>{{ $getSetting->email }}</p>
                        <p><i class="fas fa-phone-alt"></i>{{ $getSetting->phone }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tb-menu">
                                                @guest

                        <a href="{{ route('register') }}">Register</a>
                        <a href="{{ route('login') }}">Login</a>
                        @endguest
                        @auth
                        <a href="javascript:void(0)" onclick="if(confirm('Are you sure you want to logout?')){document.getElementById('logout-form').submit()} return false ">Logout</a>
                        @endauth
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Bar Start -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4">
                    <div class="b-logo">
                        <a href="index.html">
                            <img src="{{ asset('assets/frontend/'.$getSetting->logo) }}" alt="Logo" />
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4">
                    <div class="b-ads">

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <form action="{{ route('frontend.search') }}" method="POST">
                        @csrf
                        <div class="b-search">
                            <input name="search" type="text" placeholder="Search" />
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Nav Bar Start -->
    <div class="nav-bar">
        <div class="container">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="{{ route('frontend.index') }}" class="nav-item nav-link active">Home</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">categories</a>
                            <div class="dropdown-menu">
                                @foreach ($categories as $category )
                                <a href="{{ route('frontend.category.posts',$category->slug) }}" title="{{ $category->name }}" class="dropdown-item">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('frontend.contact.index') }}" class="nav-item nav-link">Contact Us</a>

                        <a href="{{ route('frontend.dashboard.profile') }}" class="nav-item nav-link">Dashboard</a>
                    </div>
                    <div class="social ml-auto">
                         <!-- Notification Dropdown -->
 <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-bell"></i>
    <span class="badge badge-danger">
        {{ auth()->user()->unreadNotifications->count() }}
    </span>
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" style="width: 350px;">
    <h6 class="dropdown-header">Notifications</h6>

        @forelse (auth()->user()->unreadNotifications->take(5) as $notification)
<div class="dropdown-item d-flex justify-content-between align-items-center">
            <p>{{ substr($notification->data['post_title'], 0, 5)}}</p>
            <span>{{ $notification->data['comment'] }}</span>
            <a href="{{ $notification->data['link'] }}?notify={{ $notification->id }}"><i class="fa fa-eye"></i></a>
        </div>
        @empty
            <p>No notifications</p>
        @endforelse

         <!-- <div class="dropdown-item text-center">No notifications</div>  -->

</div>
                        <a href="{{ $getSetting->twitter }}"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $getSetting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $getSetting->instagram }}"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $getSetting->youtube }}"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->
