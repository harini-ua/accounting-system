{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Contracts'))

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection


{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- contract list start -->
    <section class="contracts-list-wrapper users-list-wrapper section animate fadeLeft">

        <div class="card slide-down-block">
            <div class="card-content">
                @include('pages.contract.partials._form')
            </div>
        </div>

        <div class="create-btn add-item-btn slide-down-btn">
            <a href="#" class="waves-effect waves-light btn">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
        </div>
        <div class="card-panel filter-panel accounts-page-card-panel">
            <h6 class="width-100 mb-1">Filters</h6>
            <div class="filter-block flex-wrap-important">
                <x-filter
                        table="contracts-list-datatable"
                        :options="$statusToCollection"
                        url="{{ route('contracts.index') }}"
                        name="status_filter"
                        title="By Status"
                        className="filter-btn contract-filter-action"
                />
                <x-filter
                        table="contracts-list-datatable"
                        :options="$clientsToCollection"
                        url="{{ route('contracts.index') }}"
                        name="client_filter"
                        title="By Client"
                />
                <x-filter
                        table="contracts-list-datatable"
                        :options="$salesManagersToCollection"
                        url="{{ route('contracts.index') }}"
                        name="sales_managers_filter"
                        title="By Sales Manager"
                />

            </div>
            <x-reset-filters/>
        </div>
        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="responsive-table">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- client list ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/contracts.js')}}"></script>
@endsection
