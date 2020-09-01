{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "$monthName $year")

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')

@endsection

{{-- page content --}}
@section('content')
    <div id="vue-app" class="users-list-wrapper section">
        {{-- controls start --}}
        <div class="card-panel filter-panel accounts-page-card-panel">
            Filters
        </div>
        {{-- controls end --}}
        {{-- content start --}}
        <section class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <!-- datatable start -->
                    <div class="responsive-table overflow-x-auto">
                        <vacation-month-table
                            year="{{ $year }}"
                            month="{{ $month }}"
                            paid="{{ \App\Enums\VacationPaymentType::Paid }}"
                            :days="{{ json_encode($days, JSON_NUMERIC_CHECK) }}"
                        ></vacation-month-table>
                    </div>
                    <!-- datatable ends -->
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

