{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Calendar " . $paginator->year())

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div id="vue-app" class="section animate fadeLeft">
        <div class="row invoice-view-wrapper">
            {{-- content start --}}
            <div class="col xl6 l12 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        <calendar-table
                            quarter="first"
                            quarter-name="I quarter"
                            update-cell-url="{{ url('/calendar/updateMonth') }}"
                        ></calendar-table>
                    </div>
                    <div class="card-content">
                        <calendar-table
                            quarter="second"
                            quarter-name="II quarter"
                            update-cell-url="{{ url('/calendar/updateMonth') }}"
                            half-year="first"
                        ></calendar-table>
                    </div>
                    <div class="card-content">
                        <calendar-table
                            quarter="third"
                            quarter-name="III quarter"
                            update-cell-url="{{ url('/calendar/updateMonth') }}"
                        ></calendar-table>
                    </div>
                    <div class="card-content">
                        <calendar-table
                            quarter="fourth"
                            quarter-name="IV quarter"
                            update-cell-url="{{ url('/calendar/updateMonth') }}"
                            half-year="second"
                            year="2020"
                        ></calendar-table>
                    </div>
                </div>
            </div>
            {{-- content end --}}
            <div class="holidays-wrap col xl4 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        <holidays :data="{{ $holidays->toJson() }}" store-url="{{ route('holidays.store') }}"></holidays>
                    </div>
                </div>
            </div>
            {{-- actions start  --}}
            <div class="col xl2 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <ul class="pagination center-align">
                            <li class="{{ $paginator->prev() ? 'waves-effect' : 'disabled' }}">
                                @if($paginator->prev())<a href="{{ $paginator->prev() }}">@else<span>@endif
                                    <i class="material-icons">chevron_left</i>
                                @if($paginator->prev())</a>@else</span>@endif
                            </li>
                            <li class="{{ $paginator->next() ? 'waves-effect' : 'disabled' }}">
                                @if($paginator->next())<a href="{{ $paginator->next() }}">@else<span>@endif
                                    <i class="material-icons">chevron_right</i>
                                @if($paginator->next())</a>@else</span>@endif
                            </li>
                        </ul>
                        <div class="invoice-action-btn">
                            <a href="{{ route('calendar.create') }}" class="btn-block btn waves-effect waves-light">
                                <i class="material-icons">add</i>
                                <span>Add</span>
                            </a>
                        </div>
                        @if(!$paginator->isCurrentYear() && $paginator->isOutSide())
                            <calendar-delete-button
                                title="Delete"
                                url="{{ route('calendar.destroy', $paginator->year()) }}"
                                default-url="{{ route('calendar.index') }}"
                            ></calendar-delete-button>
                        @endif
                    </div>
                </div>
            </div>
            {{-- actions end  --}}
        </div>
    </div>
    {{-- Content Area Ends --}}
@endsection

{{-- vendor scripts --}}
@section('vendor-script')

@endsection

{{-- page scripts --}}
@section('page-script')
    <script>
        window.preState = {
            months: {!! $months->toJson(JSON_NUMERIC_CHECK) !!},
            fetchMonths: '{{ route('calendar.months', $paginator->year()) }}',
        }
    </script>
    <script src="{{asset('js/vue/calendar.js')}}"></script>
@endsection
