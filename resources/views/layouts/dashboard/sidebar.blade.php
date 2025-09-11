        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    {{-- <i class="fas fa-laugh-wink"></i> --}}
                </div>
                <div class="sidebar-brand-text mx-3"> News </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @can('home')
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.index') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
            @endcan


            <!-- Divider -->
            <hr class="sidebar-divider">
            {{-- Categories Management --}}
            @can('categories')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Categories Management</span></a>
                </li>
            @endcan
            {{--  Posts Management --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Posts"
                    aria-expanded="true" aria-controls="Posts">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>Posts Management</span>
                </a>
                <div id="Posts" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can('index_posts')
                            <a class="collapse-item" href="{{ route('admin.posts.index') }}">Posts</a>
                        @endcan
                        @can('create_posts')
                            <a class="collapse-item" href="{{ route('admin.posts.create') }}">Create Post </a>
                        @endcan

                    </div>
                </div>
            </li>

            {{-- Users Management --}}
            @can('users')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users Management</span>
                    </a>
                    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('admin.users.index') }}">Users</a>
                            <a class="collapse-item" href="{{ route('admin.users.create') }}">Add User </a>

                        </div>
                    </div>
                </li>
            @endcan
            {{-- Admins Management --}}
            @can('admins')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Admins"
                        aria-expanded="true" aria-controls="Admins">
                        <i class="fas fa-fw fa-user-shield"></i>
                        <span>Admins Management</span>
                    </a>
                    <div id="Admins" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('admin.admins.index') }}">Admins</a>
                            <a class="collapse-item" href="{{ route('admin.admins.create') }}">Create Admin </a>

                        </div>
                    </div>
                </li>
            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider">
            {{-- Authorizations --}}
            @can('authorizations')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-lock"></i>
                        <span>Authorizations</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('admin.authorizations.index') }}">Roles</a>
                            <a class="collapse-item" href="{{ route('admin.authorizations.create') }}">Add New Role</a>
                        </div>
                    </div>
                </li>
            @endcan
            {{-- Settings --}}
            @can('settings')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Settings</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('admin.settings.index') }}">Settings</a>
                            <a class="collapse-item" href="{{ route('admin.related-site.index') }}">Related Sites</a>

                        </div>
                    </div>
                </li>
            @endcan
            {{-- Contacts --}}
            @can('contacts')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>Contacts</span></a>
                </li>
            @endcan
            {{-- Notifications --}}
            @can('notifications')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span>Notifications</span></a>
                </li>
            @endcan



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
