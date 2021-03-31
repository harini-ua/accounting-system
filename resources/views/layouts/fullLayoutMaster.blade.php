{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
{!! update_page_config($pageConfigs) !!}
@endisset
<!DOCTYPE html>
@php
    // confiData variable layoutClasses array in Helper.php file.
    $configData = app_classes();
@endphp
<html class="loading"
      lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
      data-textdirection="ltr">
{{-- BEGIN: HEAD --}}
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Calculator</title>
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon/favicon-32x32.png') }}">

    <!-- Include core + vendor Styles -->
    @include('panels.styles')
</head>
{{-- END: HEAD --}}
<body
        class="{{$configData['mainLayoutTypeClass']}} @if(!empty($configData['bodyCustomClass'])) {{$configData['bodyCustomClass']}} @endif"
        data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
@include('sweetalert::alert')
<div class="row">
    <div class="col s12">
        <div class="container">
            <!-- PAGE MAIN CONTENT -->
            @yield('content')
        </div>
        {{-- OVERLAY --}}
        <div class="content-overlay"></div>
    </div>
</div>
{{-- VENDOR AND PAGE SCRIPTS --}}
@include('panels.scripts')
</body>

</html>
