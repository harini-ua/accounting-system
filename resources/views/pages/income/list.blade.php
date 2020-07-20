{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __("Actual Income"))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <x-totals title="Invoiced" :options="$accountTypes" relation="invoicedSum" titleColor="white-text"/>
    <x-totals title="Received" :options="$accountTypes" relation="receivedSum"/>
    <!-- list -->
    <section class="users-list-wrapper section">
        <x-filter
            table="incomes-list-table"
            :options="$wallets"
            url="{{ route('incomes.list') }}"
            name="wallet_filter"
            title="Filter by Wallet"
            className="filter-btn invoice-filter-action mr-3"
        />
        <x-date-filter start="{{ $startDate }}" end="{{ $endDate }}" table="incomes-list-table"/>
        <x-filter
            table="incomes-list-table"
            :options="$clients"
            url="{{ route('incomes.list') }}"
            name="client_filter"
            title="Filter by Client"
        />

        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <!-- datatable start -->
                    <div class="responsive-table">
                        {{ $dataTable->table() }}
                    </div>
                    <!-- datatable ends -->
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
{{--    <script src="{{asset('js/scripts/accounts.js')}}"></script>--}}
@endsection
