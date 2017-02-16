<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if(Auth::check())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('') }}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ '' }}</p>
                    <small>{{ '' }}</small>
                </div>
            </div>
    @endif
    <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @if(true)
                <li class="header">Administration</li>
                {{-- <li class="{{areActiveRoutes('admin.home')}}"><a href="{{ route('admin.home') }}"><i
                                 class='fa fa-home'></i> <span>Dashboard</span></a></li>--}}
                @php
                    $menu = [
                        'users' => [
                            'Les utilisateurs',
                            'users'
                        ],
                        'companies' => [
                            'Les entreprises',
                            'building'
                        ],
                        'categories' => [
                            'Les catégories',
                            'map-marker'
                        ],
                        'options' => [
                            'Les options',
                            'sliders'
                        ],
                        'posts' => [
                            'Les actualités',
                            'newspaper-o'
                        ],
                        'config-variables' => [
                            'Les textes',
                            'commenting-o '
                        ],
                    ];
                @endphp

                {{--@foreach($menu as $model => list($label, $fa))
                    <li class="{{areActiveRoutes('admin.'.$model)}}"><a href="{{ route('admin.'.$model.'.index') }}"><i
                                    class='fa fa-{{$fa}}'></i> <span>{{$label}}</span></a></li>
                @endforeach--}}
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
