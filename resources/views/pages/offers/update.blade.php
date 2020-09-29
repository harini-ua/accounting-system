{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Edit Offer'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- edit start -->
    <section class="offer-update-wrapper users-list-wrapper section animate fadeLeft">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        @include('pages.offers.partials._form')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/checkbox-input.js')}}"></script>
    <script src="{{asset('js/scripts/offer.js')}}"></script>
@endsection