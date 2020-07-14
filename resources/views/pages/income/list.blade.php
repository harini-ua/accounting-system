{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __("Income listing"))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/accounts.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- list -->
    <section class="list-wrapper section">
        <x-filter
            table="incomes-list-table"
            :options="$wallets"
            url="{{ route('incomes.list') }}"
            name="wallet_filter"
            title="Filter by Wallet"
            className="filter-btn invoice-filter-action mr-3"
        />
        <x-date-filter table="incomes-list-table"/>
        <x-filter
            table="incomes-list-table"
            :options="$clients"
            url="{{ route('incomes.list') }}"
            name="client_filter"
            title="Filter by Client"
        />
        <div class="responsive-table">
            {{ $dataTable->table() }}
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
    @stack('components-scripts')
    <script src="{{asset('js/scripts/accounts.js')}}"></script>
@endsection
