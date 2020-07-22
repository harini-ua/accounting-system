{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Money Flows')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pages/accounts.css')}}">--}}
@endsection

{{-- page content --}}
@section('content')
    <!-- list -->
    <section class="users-list-wrapper section">
        <div class=" create-btn invoice-create-btn add-item-btn">
            <a href="{{ route('money-flows.create') }}" class="btn waves-effect waves-light invoice-create z-depth-4">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
        </div>
        <div class="">
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
        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    {{--<script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>--}}
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    {{--<script src="{{asset('js/scripts/accounts.js')}}"></script>--}}
@endsection