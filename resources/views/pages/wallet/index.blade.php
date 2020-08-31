{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Wallets')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">

    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/clients.css')}}">--}}

    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-wallets.css')}}">--}}
@endsection

{{-- page content --}}
@section('content')

    <!-- Sidebar Area Starts -->
    <section class="users-list-wrapper section animate fadeLeft">
        {{--<div class="page-layout">--}}
        <div class="card slide-down-block">
            <div class="card-content">
                <div>
                    <!-- form start -->
                    <form id="add-wallet-form"
                        class="handle-submit-form edit-contact-item"
                        data-created-item="wallet"
                        method="POST"
                        action="{{ route('wallets.store') }}"
                    >
                        @csrf
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="input-field col s12">
                                    <input id="name" name="name" type="text" class="validate">
                                    <label for="name">Name</label>
                                    <span class="error-span"></span>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <x-select
                                        name="wallet_type_id"
                                        title="Wallet Type"
                                        :options="$walletTypes"
                                        firstTitle="Wallet Type"
                                ></x-select>
                            </div>
                        </div>
                        <div class="pl-0 pr-0 right-align">
                            <a href="#" class=" mr-1 btn waves-effect chanel-btn slide-up-btn">Cancel</a>
                            <button type="submit" class="btn waves-effect waves-light">
                                <span>Add Wallet</span>
                            </button>
                        </div>
                    </form>

                    <!-- form start end-->
                </div>
            </div>
        </div>
        <!-- Sidebar Area Ends -->

        <!-- Content Area Starts -->
        <div class="create-btn add-item-btn slide-down-btn">
            <a href="#" class="waves-effect waves-light btn slide-down-btn">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
        </div>
        <div class="users-list-table animate fadeRight">

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
        {{--</div>--}}
    </section>

    <!-- Content Area Ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/page-wallets.js')}}"></script>
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
@endsection
