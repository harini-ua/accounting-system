{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Edit Salary Review'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/salary-reviews.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="salary-review-edit-wrapper section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        @include('pages.salary-review.partials._form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/form_repeater/jquery.repeater.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
    <script src="{{asset('js/scripts/salary-reviews.js')}}"></script>
@endsection
