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
                            <form id="add-wallet-form" class="edit-contact-item mb-5 mt-5" method="POST" action="{{ route('wallets.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix"> account_balance_wallet </i>
                                        <input id="name" name="name" type="text" class="validate" value="{{ old('name') }}">
                                        <label for="name">Wallet Name</label>
                                        @error('name')
                                        <span class="helper-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix"> account_balance_wallet </i>
                                        <select id="wallet_type_id" name="wallet_type_id">
{{--                                            @foreach ($walletTypes as $walletType)--}}
{{--                                                <option {{ old('wallet_type_id') == $walletType->id ? 'selected' : '' }}--}}
{{--                                                        value="{{ $walletType->id }}">--}}
{{--                                                    {{ $walletType->name }}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
                                        </select>
                                        <label for="wallet_type_id">Wallet Type</label>
                                    </div>
                                </div>
                            </form>
                            <div class="card-action pl-0 pr-0 right-align">
                                <button class="btn-small waves-effect waves-light add-wallet">
                                    <span>Add Income</span>
                                </button>
                            </div>
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
                <span class="hide-on-small-only">Filter by Client</span>
                <i class="material-icons">keyboard_arrow_down</i>
            </a>
            <!-- Dropdown Structure -->
            <ul id='btn-filter' class='dropdown-content'>
                <li><a class="option" data-id="all" href="#!">All</a></li>
{{--                @foreach($wallets as $wallet)--}}
{{--                    <li><a class="option" data-id="{{ $wallet->id }}" href="#!">{{ $wallet->name }}</a></li>--}}
{{--                @endforeach--}}
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

 page scripts
@section('page-script')
    {{ $dataTable->scripts() }}
    @stack('components-scripts')
    <script src="{{asset('js/scripts/accounts.js')}}"></script>
@endsection
