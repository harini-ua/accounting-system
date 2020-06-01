{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Wallets')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-wallets.css')}}">
@endsection

{{-- page content --}}
@section('content')

<!-- Sidebar Area Starts -->
<div class="sidebar-left sidebar-fixed">
  <div class="sidebar">
    <div class="sidebar-content">
      <div class="sidebar-header">
        <div class="sidebar-details">
          <h5 class="m-0 sidebar-title"><i class="material-icons app-header-icon text-top">account_balance_wallet</i> Wallets
          </h5>
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
<!-- Sidebar Area Ends -->

<!-- Content Area Starts -->
<div class="content-area content-right">
  <div class="app-wrapper">
      <div class="datatable-search">
          <i class="material-icons mr-2 search-icon">search</i>
          <input type="text" placeholder="Search Wallet" class="app-filter" id="global_filter">
      </div>
    <div id="button-trigger" class="card card card-default scrollspy border-radius-6 fixed-width">
      <div class="card-content p-0">
        {{ $dataTable->table() }}
      </div>
    </div>
  </div>
</div>
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
