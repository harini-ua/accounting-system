{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Accounts')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/accounts.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="animate fadeLeft">
        <x-totals :options="$accountTypes" relation="accountsSum"/>
        <div class="card-panel filter-panel accounts-page-card-panel">
            <h6 class="width-100">Filters</h6>
            <div class="filter-block mb-0">
                <x-date-filter start="{{ $startDate->format('d-m-Y') }}" end="{{ $endDate->format('d-m-Y') }}" table="accounts-list-datatable"/>
                <x-filter
                        table="accounts-list-datatable"
                        :options="$wallets"
                        url="{{ route('accounts.index') }}"
                        name="wallet_filter"
                        title="By Wallet"
                />
            </div>
            <x-reset-filters/>
        </div>
        <section class="users-list-wrapper section">
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
    </div>
    {{--<section class="list-wrapper section">--}}
    {{--</section>--}}
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    {{--<script src="{{asset('js/scripts/accounts.js')}}"></script>--}}

@endsection
