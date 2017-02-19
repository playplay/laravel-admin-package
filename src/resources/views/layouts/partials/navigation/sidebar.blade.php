<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if(auth()->check())
            @php($user = auth()->user())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('') }}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ $user->name }}</p>
                    <small>{{ $user->email }}</small>
                </div>
            </div>
        @endif
        <!-- Sidebar Menu -->
        {!! AdminShow::menu('sidebar', 'Menu', 'sidebar-menu') !!}
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
