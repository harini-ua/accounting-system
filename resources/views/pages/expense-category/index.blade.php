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

    <!-- Sidebar Area Starts -->
    <section class="users-list-wrapper section">
        <div class="card slide-down-block">
            <div class="card-content">
                @include('pages.expense-category.partials._form')
            </div>
        </div>
        <div class="create-btn add-item-btn slide-down-btn">
            <a href="#" class="waves-effect waves-light btn">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
        </div>

        <!-- Sidebar Area Ends -->

        <!-- Content Area Starts -->
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
