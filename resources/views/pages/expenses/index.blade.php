{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Expense categories")

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
@endsection

{{-- page content --}}
@section('content')
    <div class=" create-btn invoice-create-btn add-item-btn">
        <a href="{{ route('expenses.create') }}" class="btn waves-effect waves-light invoice-create">
            <i class="material-icons">add</i>
            <span class="hide-on-small-only">Add</span>
        </a>
    </div>
    <section class="users-list-wrapper section animate fadeLeft">
        <div class="totals-container totals-2-col">
            <div class="col s12 m6">
                <x-totals title="Planned" :options="$accountTypes" relation="expensesPlanSum"/>
            </div>
            <div class="col s12 m6">
                <x-totals title="Real" :options="$accountTypes" relation="expensesRealSum"/>
            </div>
        </div>


        <ul class="collapsible mt-0">
            <li class="{{ active(config('general.ui.datatable.filter.show')) }}">
                <div class="collapsible-header p-0">
                    <div class="box-shadow-none width-100  card-panel m-0 display-flex align-items-center justify-content-between">
                        <div class="display-flex align-items-center">
                            <i class="material-icons collapsible-arrow">arrow_upward</i>
                            <h6 class="m-0">  {{ __('Filters') }}</h6>
                        </div>
                        <x-reset-filters/>
                    </div>
                </div>
                <div class="collapsible-body mt-0 p-0">
                    <div class="m-0 box-shadow-none filter-panel accounts-page-card-panel card-panel">
                        <div class="filter-block mb-0">
                            <x-date-filter start="{{ $startDate }}" end="{{ $endDate }}" table="expense-datatable-table"/>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
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
    <script src="{{asset('js/scripts/filters.js')}}"></script>
@endsection
