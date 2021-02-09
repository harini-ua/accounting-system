{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Salary Reviews'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/salary-reviews.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="create-btn invoice-create-btn">
        <a href="{{ route('salary-reviews.create') }}" class="btn waves-effect waves-light invoice-create z-depth-4">
            <i class="material-icons">add</i>
            <span class="hide-on-small-only">{{ __("Add") }}</span>
        </a>
    </div>
    <section class="salary-review-list-wrapper users-list-wrapper section animate fadeLeft">
        <div class="filters-panel">
            <ul class="collapsible">
                <li class="active">
                    <div class="collapsible-header">
                        <i class="material-icons">filter_list</i>{{ __('Filters') }}
                    </div>
                    <div class="collapsible-body" style="background-color: white">
                        <div class="filter-block">
                            <div class="row">
                                <div class="col s6 m3">
                                    <x-checkbox-filter
                                            table="salary-review-list-datatable"
                                            title="Show All"
                                            name="all_people"
                                            url="{{ route('salary-reviews.index') }}">
                                    </x-checkbox-filter>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
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
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/salary-reviews-quarter.js')}}"></script>
@endsection
