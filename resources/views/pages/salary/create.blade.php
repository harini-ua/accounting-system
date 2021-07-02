{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Create Salary'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        @include('pages.salary.partials._form')
                        @php dump($currencies); @endphp
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
@endsection

{{-- page scripts --}}
@section('page-script')
    <script>
        const currencies = {!! json_encode($currencies, JSON_NUMERIC_CHECK) !!};
        const fields = {!! json_encode($fields, JSON_NUMERIC_CHECK) !!};
    </script>
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
    <script src="{{asset('js/scripts/salary.js')}}"></script>
@endsection
