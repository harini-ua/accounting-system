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

    <div class="card-panel filter-panel accounts-page-card-panel mb-2">
        <div class="filter-block">
            <x-date-filter start="{{ $startDate }}" end="{{ $endDate }}" table="expense-datatable-table"/>
        </div>
        <x-reset-filters/>
    </div>

    <x-totals title="Planned" :options="$accountTypes" relation="expensesPlanSum"/>
    <x-totals title="Real" :options="$accountTypes" relation="expensesRealSum"/>

    <section class="users-list-wrapper section animate fadeUp">
        <div class=" create-btn invoice-create-btn add-item-btn">
            <a href="{{ route('expenses.create') }}" class="btn waves-effect waves-light invoice-create z-depth-4">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
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
