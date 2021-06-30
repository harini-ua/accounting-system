{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title', __('Final Payslip'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/final-payslip.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="section final-payslip-form-wrapper">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        @include('pages.final-payslip.partials._form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/pjax/jquery.pjax.js')}}"></script>
    <script src="{{asset('vendors/moment/moment.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script>
      const currencies = {!! json_encode($currencies, JSON_NUMERIC_CHECK) !!};
      const fields = {!! json_encode($fields, JSON_NUMERIC_CHECK) !!};
    </script>
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
    <script src="{{asset('js/scripts/final-payslip.js')}}"></script>
@endsection
