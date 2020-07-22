{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Create Contract'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- client create start -->
    <div id="contracts" class="section">
        <div class="row">
            <div class="col s12">
                <div class="card card card-default scrollspy">
                    <div class="card-content">
                        @include('pages.contract.partials._form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- client create ends -->
@endsection

{{-- page scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection
