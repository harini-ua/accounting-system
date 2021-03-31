<body
        class="{{$configData['mainLayoutTypeClass']}} @if(!empty($configData['bodyCustomClass']) && isset($configData['bodyCustomClass'])) {{$configData['bodyCustomClass']}} @endif @if($configData['isMenuCollapsed'] && isset($configData['isMenuCollapsed'])){{'menu-collapse'}} @endif"
        data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
@include('sweetalert::alert')
{{-- BEGIN: HEADER --}}
<header class="page-topbar" id="header">
    @include('panels.navbar')
</header>
{{-- END: HEADER --}}
{{-- BEGIN: SIDENAV --}}
@include('panels.sidebar')
{{-- END: SIDENAV --}}
{{-- BEGIN: PAGE MAIN --}}
<div id="main">
    <div class="row">
        @if ($configData["navbarLarge"] === true)
            @if(($configData["mainLayoutType"]) === 'vertical-modern-menu')
                <div
                        class="content-wrapper-before @if(!empty($configData['navbarBgColor'])) {{$configData['navbarBgColor']}} @else {{$configData["navbarLargeColor"]}} @endif">
                </div>
            @else
                <div class="content-wrapper-before {{$configData["navbarLargeColor"]}}"></div>
            @endif
        @endif
        @if($configData["pageHeader"] === true && isset($breadcrumbs))
            {{-- BREADCRUMB --}}
            @include('panels.breadcrumb')
        @endif
        <div class="col s12">
            <div class="container">
                {{-- MAIN PAGE CONTENT --}}
                @yield('content')
            </div>
            {{-- OVERLAY --}}
            <div class="content-overlay"></div>
        </div>
    </div>
</div>
{{-- END: PAGE MAIN --}}
{{-- FOOTER --}}
@include('panels.footer')
{{-- VENDOR AND PAGE SCRIPTS --}}
@include('panels.scripts')
</body>
