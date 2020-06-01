{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Account List')

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
    <!-- invoice list -->
    <section class="invoice-list-wrapper section">
        <h5 class="mb-2">Accounts</h5>
        <!-- Options and filter dropdown button-->
        <div class="invoice-filter-action mr-3">
            <input type="text" class="datepicker" placeholder="Start date">
        </div>
        <div class="invoice-filter-action mr-3">
            <input type="text" class="datepicker" placeholder="End date">
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
