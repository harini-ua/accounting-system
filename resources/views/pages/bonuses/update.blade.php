{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Edit Bonus'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- edit start -->
    <div class="section">
        <div class="row">
            <div class="col s12 m6 l6">
                <div class="card">
                    <div class="card-content">
                        @include('pages.bonuses.partials._form')
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6"></div>
        </div>
    </div>
    <!-- edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection