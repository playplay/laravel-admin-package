<!DOCTYPE html>
<html lang="fr">
    @include('admin::layouts.partials.html.head')
    <body class="{{ config('admin.skin') }} {{ config('admin.layout') }}">
        <div class="wrapper">
            @include('admin::layouts.partials.navigation.mainheader')
            @include('admin::layouts.partials.navigation.sidebar')

            <div class="content-wrapper">
                @if(!isset($no_header))
                    @include('admin::layouts.partials.navigation.contentheader')
                @endif

                <section class="content {{ $no_padding ?? '' }}">
                    @yield('main-content')
                </section>
            </div>

            @include('admin::layouts.partials.navigation.footer')

            <div class="modal fade" id="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        </div>

        @include('admin::layouts.partials.html.scripts')

        @include('admin::layouts.partials.alerts')
    </body>
</html>
