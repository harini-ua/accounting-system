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
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="animate section fadeLeft">
    <div class="totals-container row totals-2-col">
        <div class="col s12 m6">
            <x-totals title="Invoiced" :options="$accountTypes" relation="invoicedSum"/>
        </div>
        <div class="col s12 m6">
            <x-totals title="Received" :options="$accountTypes" relation="receivedSum"/>
        </div>
    </div>
    <ul class="collapsible card">
        <li class="{{ active(config('general.ui.datatable.filter.show')) }}">
            <div class="collapsible-header p-0">
                <div class="box-shadow-none width-100  card-panel m-0 display-flex align-items-center justify-content-between">
                    <div class="display-flex align-items-center">
                        <i class="material-icons collapsible-arrow">arrow_upward</i>
                        <h6 class="m-0">  {{ __('Filters') }}</h6>
                    </div>
                    <x-reset-filters/>
                </div>
            </div>
            <div class="collapsible-body mt-0 p-0">
                <div class="m-0 box-shadow-none filter-panel accounts-page-card-panel card-panel">
                    <div class="filter-block mb-0">
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
                            <x-checkbox-filter title="Received" name="received" table="incomes-list-table"
                                               url="{{ route('incomes.list') }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
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
    </section>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    {{--<script src="{{asset('js/scripts/accounts.js')}}"></script>--}}
@endsection
