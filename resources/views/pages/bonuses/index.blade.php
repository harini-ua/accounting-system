{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Bonuses'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/extensions/fixedColumns/css/fixedColumns.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
{{--    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/bonuses.css')}}"
@endsection

{{-- page content --}}
@section('content')
    <!-- bonus list -->
    <section class="bonus-list-wrapper users-list-wrapper section">
        <div class="row">
            <div class="col s12">
                <div class="card-panel filter-panel accounts-page-card-panel">
                    <div class="filter-block">
                        <div class="filter-block-buttons">
                            <x-filter
                                    table="bonuses-list-datatable"
                                    :options="$calendarYears"
                                    url="{{ route('bonuses.index') }}"
                                    name="year_filter"
                                    title="By Year"
                                    all="0"
                            />
                        </div>
                    </div>
                    <x-reset-filters/>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="row">
                <div class="col s12">
                    <ul class="tabs tabs-fixed-width ">
                        <li class="tab col m3"><a class="active" href="#sales-tab">{{ __('Sales Manager') }}</a></li>
                        <li class="tab disabled col m3"><a class="" href="#recruiter-tab">{{ __('Recruiter') }}</a></li>
                    </ul>
                </div>
                <div id="sales-tab" class="col s12">
                    <div class="card-content">
                        <div class="responsive-table overflow-x-auto">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
                <div id="recruiter-tab" class="col s12">
                    <div class="card-content">
                        <div class="responsive-table overflow-x-auto">
                            No result
                        </div>
                    </div>
                </div>

    {{--            <div class="col s12">--}}
    {{--                <div class="users-list-table">--}}
    {{--                    <div class="card">--}}
    {{--                        <div class="card-content">--}}
    {{--                            <div class="responsive-table overflow-x-auto">--}}
    {{--                                {{ $dataTable->table() }}--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
            </div>
        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/fixedColumns/js/dataTables.fixedColumns.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/bonuses.js')}}"></script>
@endsection
