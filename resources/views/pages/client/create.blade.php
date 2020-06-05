{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Create Client'))

{{-- page content --}}
@section('content')
    <!-- client create start -->
    <div id="clients" class="section">
        <div class="row">
            <div class="col s12">
                <div class="card card card-default scrollspy">
                    <div class="card-content">
                        @include('pages.client.partials._form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- client create ends -->
@endsection
