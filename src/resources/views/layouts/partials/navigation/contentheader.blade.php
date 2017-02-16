<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader.title', 'Page Header ici avec @section(\'contentheader.title\', \'Mon titre\')')
        <small>@yield('contentheader.description', 'Page description ici avec @section(\'contentheader.description\', \'Ma description\')')</small>
    </h1>
    @hasSection('contentheader.elements')
        <span class="headerElems">
        @yield('contentheader.elements')
        </span>
    @else
        @hasSection('contentheader.section')
            <ol class="breadcrumb">
                <li><a href="@yield('contentheader.section.url')">
                        <i class="fa @yield('contentheader.section.fa')"></i>
                        @yield('contentheader.section')</a>
                </li>
                @hasSection('contentheader.subsection')
                    <li class="active"> @yield('contentheader.subsection') </li>@endif
            </ol>
        @endif
    @endif
</section>
