{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "$monthName $year")

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/salary-month.css')}}">
@endsection

{{-- page content --}}
@section('content')
{{--    <div class="pt-1"></div>--}}
    <div class="create-btn invoice-create-btn">
        <a href="{{ route('payslip.print', ['year' => $year, 'month' => $month]) }}"
           class="btn indigo waves-effect waves-light invoice-create">
            <i class="material-icons">print</i>
            <span class="hide-on-small-only"> {{ __("Final payslips") }}</span>
        </a>
    </div>
    <section class="salary-month-list-wrapper users-list-wrapper section animate fadeLeft">
        <div class="card">
            <div class="card-content">
                <div class="responsive-table users-list-table overflow-x-auto">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </section>
    {{-- Content Area Ends --}}
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/salary-month.js')}}"></script>
@endsection
