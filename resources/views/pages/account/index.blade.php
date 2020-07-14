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
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/accounts.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="faq row totals-list">
        @foreach ($accountTypes as $accountType)
            <div class="col s12 m6 xl3">
                <a class="black-text" href="page-faq-detail.html">
                    <div class="card z-depth-0 grey lighten-3 faq-card">
                        <div class="card-content center-align">
                            {{ $accountType->name }}: {{ $accountType->accountsSum }}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
    <div class="card-panel accounts-page-card-panel">
        <div class="row">
            <form>
                <div class="col s12 m12 l3 input-field">
                    <div class="invoice-filter-action mr-3">
                        <input type="text" class="datepicker" placeholder="Start date"
                               value="{{ $startDate->format('d-m-Y') }}">
                    </div>
                </div>
                <div class="col s12 m12 l3 input-field">
                    <div class="invoice-filter-action mr-3">
                        <input type="text" class="datepicker" placeholder="End date"
                               value="{{ $endDate->format('d-m-Y') }}">
                    </div>
                </div>
                <div class="col s12 l6 display-flex align-items-center show-btn">
                    <div class="col s12 m4 input-field">
                        <x-filter
                                table="accounts-table"
                                :options="$wallets"
                                url="{{ route('accounts.index') }}"
                                name="wallet_filter"
                                title="Filter by Wallet"
                        />
                    </div>
                    <div class="col s12 m8">
                        <button type="button" class="btn btn-block indigo waves-effect waves-light">Reset</button>
                    </div>

                </div>
            </form>
        </div>
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
    {{--<section class="list-wrapper section">--}}
    {{--</section>--}}
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
    {{--<script src="{{asset('js/scripts/accounts.js')}}"></script>--}}
@endsection
