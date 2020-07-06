{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __("Income planning"))

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
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-wallets.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/accounts.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- Sidebar Area Starts -->
    <div class="sidebar-left sidebar-fixed">
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div class="sidebar-details">
                        <div class="mt-10 pt-2">
                            <!-- form start -->
                            <form class="edit-contact-item mb-5 mt-5" method="POST" action="{{ route('incomes.store') }}">
                                @csrf
                                <div class="row">
                                    <x-linked-selects
                                        firstName="client_id"
                                        firstTitle="Client"
                                        secondName="contract_id"
                                        secondTitle="Contract"
                                        dataUrl="/clients/clientContracts"
                                        view="components.linked-selects.clients-contracts"
                                        :options="$clients"
                                    />
                                    <x-linked-selects
                                        firstName="wallet_id"
                                        firstTitle="Wallet"
                                        secondName="account_id"
                                        secondTitle="Account"
                                        dataUrl="/wallets/walletAccounts"
                                        view="components.linked-selects.wallets-accounts"
                                        :options="$wallets"
                                    />
                                    <x-date name="plan_date" title="Planning Date"></x-date>
                                    <x-input name="plan_sum" title="Planning Sum"></x-input>
                                </div>
                                <div class="card-action pl-0 pr-0 right-align">
                                    <button class="btn-small waves-effect waves-light">
                                        <span>Add Income</span>
                                    </button>
                                </div>
                            </form>
                            <!-- form start end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar Area Ends -->
    <!-- list -->
    <section class="list-wrapper section content-area content-right">
        <!-- Options and filter dropdown button-->
        <x-date-filter table="incomes-table"/>
        <x-filter
            table="incomes-table"
            :options="$clients"
            url="{{ route('incomes.index') }}"
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

@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    @stack('components-scripts')
    <script src="{{asset('js/scripts/accounts.js')}}"></script>
@endsection
