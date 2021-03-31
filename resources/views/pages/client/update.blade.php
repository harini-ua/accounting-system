{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Edit Client'))

{{-- page content --}}
@section('content')
    <div id="clients" class="section">
        <div class="card card card-default scrollspy">
            <div class="card-content">
                @include('pages.client.partials._form')
            </div>
        </div>
    </div>
@endsection
