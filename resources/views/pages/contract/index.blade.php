{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Contract'))

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection


{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- contract list start -->
    <section class="contracts-list-wrapper users-list-wrapper section">
        <div class="create-btn invoice-create-btn">
            <a href="{{ route('contracts.create') }}" class="btn waves-effect waves-light invoice-create z-depth-4">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">{{ __('Add Contract') }}</span>
            </a>
        </div>
        <div class="card-panel filter-panel accounts-page-card-panel">
            <div class="filter-block">
                <x-filter
                        table="contracts-list-datatable"
                        :options="$status"
                        url="{{ route('contracts.index') }}"
                        name="status_filter"
                        title="By Status"
                        className="filter-btn contract-filter-action"
                />
                <x-filter
                        table="contracts-list-datatable"
                        :options="$clients"
                        url="{{ route('contracts.index') }}"
                        name="client_filter"
                        title="By Client"
                />
                <x-filter
                        table="contracts-list-datatable"
                        :options="$salesManagers"
                        url="{{ route('contracts.index') }}"
                        name="sales_managers_filter"
                        title="By Sales Manager"
                />
            </div>
            <button type="button" class="btn btn-block reset-btn">Reset</button>
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
@endsection

{{-- page script --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/contracts.js')}}"></script>
@endsection
