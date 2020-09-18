{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $person->name)

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="bonus-person-wrapper users-list-wrapper section animate fadeLeft">
        <div class="card-panel">
            <div class="row">
                <div class="col s12 m7">
                    <div class="display-flex media">
                        <div class="media-body">
                            <h6 class="media-heading">
                                <span class="users-view-name" data-select-like-a-boss="1">
                                    <a target="_blank" href="{{ route('people.show', $person) }}">{{ $person->name }}</a>
                                    {{ " (".\App\Enums\Position::getDescription($person->position_id).")" }}
                                </span>
                                <span class="grey-text">|</span>
                                <span class="users-view-username grey-text">{{ __('Salary') }}: {{ \App\Services\Formatter::currency($person->salary, \App\Enums\Currency::symbol($person->currency)) }}</span>
                            </h6>
                            <span>{{ __('Bonuses') }}:</span>
                            <span class="green-text">{{ $person->bonuses_reward }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <div class="row">
                <div class="col s12">
                    <div class="filter-panel accounts-page-card-panel">
                        <h6 class="width-100">{{ __('Filters') }}</h6>
                        <div class="filter-block">
                            <div class="filter-block-buttons">
                                <x-filter
                                        table="bonuses-person-table"
                                        :options="$calendarYears"
                                        url="{{ route('bonuses.person.show', $person) }}"
                                        name="year_filter"
                                        title="By Year"
                                        default="{{ $filters['year'] ?? null }}"
                                        all="0"
                                ></x-filter>
                                <x-filter
                                        table="bonuses-person-table"
                                        :options="$calendarMonths"
                                        url="{{ route('bonuses.person.show', $person) }}"
                                        name="month_filter"
                                        title="By Month"
                                        default="{{ $filters['month'] ?? null }}"
                                ></x-filter>
                                <x-filter
                                        table="bonuses-person-table"
                                        :options="$currency"
                                        url="{{ route('bonuses.person.show', $person) }}"
                                        name="currency_filter"
                                        title="By Currency"
                                        default="{{ $filters['currency'] ?? null }}"
                                ></x-filter>
                            </div>
                        </div>
                        <x-reset-filters></x-reset-filters>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="responsive-table users-list-table overflow-x-auto">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
@endsection
