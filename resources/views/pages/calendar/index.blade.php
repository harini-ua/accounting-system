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
            <div class="col l10 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content padding-2">
                        <ul class="tabs mb-2">
                            <li class="tab col s3"><a class="uppercase active" href="#test1">calaendar</a></li>
                            <li class="tab col s3"><a class="uppercase" href="#test2">holidays</a></li>
                        </ul>
                        <div id="test1">
                            <calendar-table
                                update-cell-url="{{ url('/calendar/updateMonth') }}"
                            ></calendar-table>
                        </div>
                        <div id="test2">
                            <holidays :data="{{ $holidays->toJson() }}"
                                      store-url="{{ route('holidays.store') }}"></holidays>
                        </div>
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
                            <a href="{{ route('calendar.create') }}" class=" display-flex justify-content-center btn waves-effect waves-light">
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
