{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Edit Client'))

{{-- page content --}}
@section('content')
    <!-- client update start -->
    <div id="clients" class="section">
        <div class="card card card-default scrollspy">
            <div class="card-content">
                @include('pages.client.partials._form')
            </div>
        </div>
    </div>
    <!-- client update ends -->
@endsection
