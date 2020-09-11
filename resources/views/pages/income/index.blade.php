{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __("Sales planning"))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-wallets.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- list -->
    <section class="users-list-wrapper section">
        <div class="card slide-down-block">
            <div class="card-content">
                <!-- form start -->
                <form class=" handle-submit-form edit-contact-item  " method="POST"
                      data-created-item="income"
                      action="{{ route('incomes.store') }}">
                    @csrf
                    <div class="row">
                        <x-linked-selects
                            firstName="client_id"
                            firstTitle="Client"
                            secondName="contract_id"
                            secondTitle="Contract"
                            dataUrl="/clients/[id]/contracts"
                            view="components.linked-selects.clients-contracts"
                            :options="$clients"
                        />
                        <x-linked-selects
                            firstName="wallet_id"
                            firstTitle="Wallet"
                            secondName="account_id"
                            secondTitle="Account"
                            dataUrl="/wallets/[id]/accounts"
                            view="components.linked-selects.wallets-accounts"
                            :options="$wallets"
                        />
                        <div class="col s12 m6">
                            <x-date name="plan_date" title="Planning Date"></x-date>
                        </div>
                        <div class="col s12 m6">
                            <x-input name="plan_sum" title="Planning Sum"></x-input>
                        </div>
                        <div class="col s12">
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-light mr-1 chanel-btn slide-up-btn">Cancel</button>
                                <button type="submit" class="btn waves-effect waves-light">
                                    Save
                                </button>
                            </div>

                        </div>
                    </div>

                </form>
                <!-- form start end-->
            </div>
        </div>
        <div class="create-btn add-item-btn slide-down-btn">
            <a href="#" class="waves-effect waves-light btn">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
        </div>
        <x-totals :options="$accountTypes" relation="planningSum"/>
        <div class="card-panel filter-panel accounts-page-card-panel">
            <div class="filter-block">
                <x-date-filter start="{{ $startDate }}" end="{{ $endDate }}" table="incomes-table"/>

                <x-filter
                    table="incomes-table"
                    :options="$clients"
                    url="{{ route('incomes.index') }}"
                    name="client_filter"
                    title="By Client"
                />
            </div>
            <x-reset-filters/>
        </div>



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
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
@endsection

@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
    {{--<script src="{{asset('js/scripts/accounts.js')}}"></script>--}}
@endsection
