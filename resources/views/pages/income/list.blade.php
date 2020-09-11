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
    <div class="totals-container totals-2-col">
            <x-totals title="Invoiced" :options="$accountTypes" relation="invoicedSum"/>
            <x-totals title="Received" :options="$accountTypes" relation="receivedSum"/>
    </div>
    <div class="card-panel filter-panel accounts-page-card-panel">
        <div class="filter-block">

            <x-date-filter start="{{ $startDate }}" end="{{ $endDate }}" table="incomes-list-table"/>
            <div class="filter-block-buttons">
                <x-filter
                    table="incomes-list-table"
                    :options="$clients"
                    url="{{ route('incomes.list') }}"
                    name="client_filter"
                    title="By Client"
                />

                <x-filter
                    table="incomes-list-table"
                    :options="$wallets"
                    url="{{ route('incomes.list') }}"
                    name="wallet_filter"
                    title="By Wallet"
                    className="filter-btn invoice-filter-action"
                />
            </div>
        </div>

        <x-checkbox-filter title="Received" name="received" table="incomes-list-table"
                           url="{{ route('incomes.list') }}"/>
        <x-reset-filters/>
    </div>
    <!-- list -->
    <section class="users-list-wrapper section">
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
    {{--<script src="{{asset('js/scripts/accounts.js')}}"></script>--}}
@endsection
