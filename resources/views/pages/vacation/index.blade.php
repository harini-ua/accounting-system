{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Vacations")

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div id="vue-app" class="users-list-wrapper section">
        {{-- controls start --}}
        <div class="card-panel filter-panel accounts-page-card-panel">
            <x-filter
                table="vacations-table"
                :options="$calendarYears"
                url="{{ route('vacations.index') }}"
                name="year_filter"
                title="Filter by Year"
                all="0"
            />
            <x-checkbox-filter
                title="Show All"
                name="show_all"
                table="vacations-table"
                url="{{ route('vacations.index') }}"
            /><x-reset-filters/>
        </div>
        {{-- controls end --}}
        {{-- content start --}}
        <section class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <!-- datatable start -->
                    <div class="responsive-table overflow-x-auto">
                        {{ $dataTable->table() }}
                    </div>
                    <!-- datatable ends -->
                </div>
            </div>
        </section>
        {{-- content end --}}
    </div>
    {{-- Content Area Ends --}}
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
@endsection
