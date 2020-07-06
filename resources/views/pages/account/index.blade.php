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
                        <h5 class="m-0 sidebar-title"> Totals
                        </h5>
                        <div class="mt-10 pt-2">
                            <div>
                                <ul class="display-grid">
                                    @foreach ($accountTypes as $accountType)
                                        <li class="sidebar-title">{{ $accountType->name }}: {{ $accountType->accountsSum }}</li>
                                    @endforeach
                                </ul>
                            </div>
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
        <div class="invoice-filter-action mr-3">
            <input type="text" class="datepicker" placeholder="Start date" value="{{ $startDate->format('d-m-Y') }}">
        </div>
        <div class="invoice-filter-action mr-3">
            <input type="text" class="datepicker" placeholder="End date" value="{{ $endDate->format('d-m-Y') }}">
        </div>
        <x-filter
            table="accounts-table"
            :options="$wallets"
            url="{{ route('accounts.index') }}"
            name="wallet_filter"
            title="Filter by Wallet"
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
    @stack('components-scripts')
    <script src="{{asset('js/scripts/accounts.js')}}"></script>
@endsection
