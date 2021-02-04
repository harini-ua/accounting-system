{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('404 Not Found'))

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-404.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="pt-1"></div>
    <section class="section section-404 p-0 m-0 height-100vh">
        <div class="row">
            <div class="col s12 center-align white">
                <img src="{{asset('images/gallery/error-2.png')}}" class="bg-image-404" alt="">
                <h1 class="error-code m-0">404</h1>
                <h6 class="mb-2">{{ strtoupper(__('Not Found')) }}</h6>
                <a class="btn waves-effect waves-light gradient-45deg-deep-purple-blue gradient-shadow mb-4"
                   href="{{ route('home')}} ">{{ __('Back TO Home') }}</a>
            </div>
        </div>
    </section>
@endsection
