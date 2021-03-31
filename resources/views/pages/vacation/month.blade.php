{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "$monthName $year")

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/data-tables.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div id="vue-app" class="section-data-tables section">
        {{-- controls start --}}
        <div class="card-panel filter-panel">
            <add-vacation></add-vacation>
            <show-all-vacations></show-all-vacations>
        </div>
        {{-- controls end --}}
        {{-- content start --}}
        <section class="section-data-tables">
            <div class="card">
                <div class="card-content">
                    <div class="responsive-table overflow-x-auto">
                        <vacation-month-table
                            year="{{ $year }}"
                            month="{{ $month }}"
                            paid="{{ \App\Enums\VacationPaymentType::Paid }}"
                            :days="{{ json_encode($days, JSON_NUMERIC_CHECK) }}"
                            :day-types="{{ json_encode(\App\Enums\DayType::days(), JSON_NUMERIC_CHECK) }}"
                        ></vacation-month-table>
                    </div>
                </div>
            </div>
        </section>
        {{-- content end --}}
    </div>
    {{-- Content Area Ends --}}
@endsection

{{-- vendor scripts --}}
@section('vendor-script')

@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/vue/vacations.js')}}"></script>
@endsection

