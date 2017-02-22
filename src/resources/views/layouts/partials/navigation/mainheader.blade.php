<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('admin.home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>{!! config('admin.sitename.short') !!}</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('admin.sitename.html') !!}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (auth()->check())
                    @php($user = auth()->user())
                    @if(session()->has('orig_user'))
                        <li>{{ link_to_action('Admin\UserController@logAs', 'Revenir à ' . session('orig_user')->name) }}</li>
                    @endif
                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i> {{ $user->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                {{--<img src="{{ '' }}" class="img-circle" alt="User Image"/>--}}
                                <p>
                                    {{ $user->name }}
                                    <small>{{ $user->email }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-default btn-flat">Mon compte</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin.auth.logout') }}" class="btn btn-default btn-flat">Déconnexion</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>