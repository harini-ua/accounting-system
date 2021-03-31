<body
        class="{{$configData['mainLayoutTypeClass']}} @if(!empty($configData['bodyCustomClass']) && isset($configData['bodyCustomClass'])) {{$configData['bodyCustomClass']}} @endif"
        data-open="click" data-menu="horizontal-menu" data-col="2-columns">
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
@include('sweetalert::alert')

{{-- BEGIN: HEADER --}}
<header class="page-topbar" id="header">
    @include('panels.horizontalNavbar')
</header>
{{-- BEGIN: SIDENAV --}}
@include('panels.sidebar')
{{-- END: SIDENAV --}}

{{-- BEGIN: PAGE MAIN --}}
<div id="main">
    <div class="row">
        @if($configData["navbarLarge"] === true && isset($configData["navbarLarge"]))
            {{-- NAVBAR LARGE --}}
            <div class="content-wrapper-before {{$configData["navbarLargeColor"]}}"></div>
        @endif

        @if ($configData["pageHeader"] === true && isset($breadcrumbs))
            {{-- BREADCRUMB --}}
            @include('panels.breadcrumb')
        @endif
        <div class="col s12">
            <div class="container">
                {{--MAIN PAGE CONTENT --}}
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
