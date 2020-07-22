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
        <div class="page-layout">
            <div class="card">
                <div class="card-content">
                    <div class="sidebar-left sidebar-fixed">
                        <div class="sidebar">
                            <div class="sidebar-content">
                                <div class="sidebar-header">
                                    <div class="sidebar-details">
                                        <div class="mt-10 pt-2">
                                            <!-- form start -->
                                            <form id="add-wallet-form" class="edit-contact-item mb-5 mt-5" method="POST"
                                                  action="{{ route('wallets.store') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <i class="material-icons prefix"> account_balance_wallet </i>
                                                        <input id="name" name="name" type="text" class="validate"
                                                               value="{{ old('name') }}">
                                                        <label for="name">Wallet Name</label>
                                                        @error('name')
                                                        <span class="helper-text">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <i class="material-icons prefix"> account_balance_wallet </i>
                                                        <select id="wallet_type_id" name="wallet_type_id">
                                                            @foreach ($walletTypes as $walletType)
                                                                <option {{ old('wallet_type_id') == $walletType->id ? 'selected' : '' }}
                                                                        value="{{ $walletType->id }}">
                                                                    {{ $walletType->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="wallet_type_id">Wallet Type</label>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="card-action pl-0 pr-0 right-align">
                                                <button class="btn-small waves-effect waves-light add-wallet">
                                                    <span>Add Wallet</span>
                                                </button>
                                            </div>
                                            <!-- form start end-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar Area Ends -->

            <!-- Content Area Starts -->
            <div class="table-wrapper users-list-table animate fadeRight">
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
        </div>
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
