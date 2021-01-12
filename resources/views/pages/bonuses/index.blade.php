{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Bonuses'))

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
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/bonuses.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- bonus list -->
    <section class="bonus-list-wrapper users-list-wrapper section animate fadeLeft">

        <ul class="collapsible m-0">
            <li class="active">
                <div class="collapsible-header p-0">
                    <div class="box-shadow-none width-100  card-panel m-0 display-flex align-items-center justify-content-between">
                        <div class="display-flex align-items-center">
                            <i class="material-icons">arrow_upward</i>
                            <h6 class="m-0">  Filters</h6>
                        </div>
                        <x-reset-filters/>
                    </div>
                </div>
                <div class="collapsible-body mt-0 p-0">
                    <div class="m-0 box-shadow-none filter-panel accounts-page-card-panel card-panel">
                        <div class="filter-block mb-0">
                            <div class="filter-block-buttons">
                                <x-filter
                                    table="bonuses-list-datatable"
                                    :options="$calendarYears"
                                    url="{{ route('bonuses.index') }}"
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

        <div class="card">
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        @foreach($positions as $tab)
                        <li class="tab col s12 m6 l3">
                            <a class="{{ $tab->id === $position->id ? 'active' : '' }}" data-bonuses-href="{{ route('bonuses.byPosition', $tab->id) }}" href="#bonuses-tab-{{$tab->id}}">{{ $tab->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @foreach($positions as $tab)
                <div id="bonuses-tab-{{$tab->id}}" class="col s12">
                    <div class="card-content">
                        <div class="responsive-table users-list-table overflow-x-auto">
                            @if($tab->id === $position->id)
                                {{ $dataTable->table() }}
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/scripts/bonuses.js')}}"></script>
@endsection
