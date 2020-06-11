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
        <div class="filter-btn">
            <!-- Dropdown Trigger -->
            <a class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href='#'
               data-target='btn-filter'>
                <span class="hide-on-small-only">Filter by Wallet</span>
                <i class="material-icons">keyboard_arrow_down</i>
            </a>
            <!-- Dropdown Structure -->
            <ul id='btn-filter' class='dropdown-content'>
                <li><a class="option" data-id="all" href="#!">All</a></li>
                @foreach($wallets as $wallet)
                    <li><a class="option" data-id="{{ $wallet->id }}" href="#!">{{ $wallet->name }}</a></li>
                @endforeach
            </ul>
        </div>
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
    <script src="{{asset('js/scripts/accounts.js')}}"></script>
@endsection
