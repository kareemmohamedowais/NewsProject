@extends('layouts.frontend.app')

@section('title')
    Notifications
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Notifications</li>
@endsection

@section('body')
       <!-- Dashboard Start-->
       <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
          <!-- User Info Section -->
          <div class="user-info text-center p-3">
            <img
              src="{{ asset(auth()->user()->image) }}"
              alt="User Image"
              class="rounded-circle mb-2"
              style="width: 80px; height: 80px; object-fit: cover"
            />
            <h5 class="mb-0" style="color: #ff6f61">{{ auth()->user()->name }}</h5>
          </div>

          <!-- Sidebar Menu -->
        <div class="list-group profile-sidebar-menu">
            <a href="{{ route('frontend.dashboard.profile') }}" class="list-group-item list-group-item-action  menu-item" data-section="profile">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="{{ route('frontend.dashboard.notification.index') }}" class="list-group-item list-group-item-action active menu-item" data-section="notifications">
                <i class="fas fa-bell"></i> Notifications
            </a>
            <a href="{{ route('frontend.dashboard.setting') }}" class="list-group-item list-group-item-action menu-item" data-section="settings">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('frontend.dashboard.notification.deleteAll') }}" style="margin-left: 270px" class="btn btn-sm btn-danger">Delete All</a>
                    </div>
                </div>
                @forelse (auth()->user()->notifications as $notify)
                <a href="{{ $notify->data['link'] }}?notify={{ $notify->id }}">
                    <div class="notification alert alert-info">
                        <strong>You have a notification from: {{ $notify->data['user_name'] }}</strong> Post title:{{ $notify->data['post_title'] }}.<br>
                        {{ $notify->created_at->diffForHumans() }}
                        <div class="float-right">
                            <button onclick="if(confirm('Are u Sure To Delete Notify?')){document.getElementById('deleteNotify').submit()} return false" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </div>
                </a>
                <form id="deleteNotify" action="{{ route('frontend.dashboard.notification.delete') }}" method="post">
                    @csrf
                    <input hidden name="notify_id" value="{{ $notify->id }}">
                </form>
                @empty
                    <div class="alert alert-info">
                        No Notifications yet!
                    </div>

                @endforelse


            </div>
        </div>
      </div>
      <!-- Dashboard End-->

@endsection
