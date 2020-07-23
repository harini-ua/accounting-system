{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Invoices List'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- invoice list -->
    <section class="invoice-list-wrapper users-list-wrapper section">
        <!-- create invoice button-->
        <div class="create-btn invoice-create-btn">
            <a href="{{ route('invoices.create') }}" class="btn waves-effect waves-light invoice-create z-depth-4">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">{{ __("Add Invoice") }}</span>
            </a>
        </div>
        <div class="card-panel accounts-page-card-panel">
            <div class="row">
                <div class="col m6 l3">
                    <x-date-filter
                            table="invoices-list-datatable"/>
                </div>
                <div class="row col s12 l6">
                    <div class="col m4 mb-3">
                        <x-filter
                                table="invoices-list-datatable"
                                :options="$status"
                                url="{{ route('invoices.index') }}"
                                name="status_filter"
                                title="Filter By Status"
                                className="filter-btn invoice-filter-action mr-3"
                        />
                    </div>
                    <div class="col m4 mb-3">
                        <x-filter
                                table="invoices-list-datatable"
                                :options="$clients"
                                url="{{ route('invoices.index') }}"
                                name="client_filter"
                                title="Filter By Client"
                        />
                    </div>
                    <div class="col m4 mb-3">
                        <x-reset-filters/>
                    </div>
                </div>
            </div>
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
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/invoice.js')}}"></script>
@endsection
