{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Payment Grid'))

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
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/payment-grid.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="create-btn invoice-create-btn">

    </div>
    <!-- offer list -->
    <section class="payment-grid-list-wrapper users-list-wrapper section animate fadeLeft">
        <ul class="collapsible card">
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
                            <div class="filter-block-buttons">
                                <x-filter
                                    table="payment-grid-list-datatable"
                                    :options="$calendarYears"
                                    url="{{ route('payments.grid.index') }}"
                                    name="year_filter"
                                    title="By Year"
                                    :default="$year"
                                    all="0"
                                />
                            </div>
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

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/payment-grid.js')}}"></script>
@endsection
