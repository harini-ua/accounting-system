{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Update Client'))

{{-- page content --}}
@section('content')
    <!-- client update start -->
    <div id="clients" class="section">
        <div class="row">
            <div class="col s12">
                <div class="card card card-default scrollspy">
                    <div class="card-content">
                        @include('pages.client.partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- client update ends -->
@endsection
