{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Calendar")

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
    <div id="vue-app" class="section">
        <div class="row invoice-view-wrapper">
            {{-- content start --}}
            <div class="col xl6 m8 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        <div class="responsive-table">
                            <calendar-table
                                quarter="first"
                                quarter-name="I quarter"
                                update-cell-url="{{ url('/calendar/updateMonth') }}"
                            ></calendar-table>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="responsive-table">
                            <calendar-table
                                quarter="second"
                                quarter-name="II quarter"
                                update-cell-url="{{ url('/calendar/updateMonth') }}"
                                half-year="first"
                            ></calendar-table>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="responsive-table">
                            <calendar-table
                                quarter="third"
                                quarter-name="III quarter"
                                update-cell-url="{{ url('/calendar/updateMonth') }}"
                            ></calendar-table>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="responsive-table">
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
            </div>
            {{-- content end --}}
            <div class="col xl4 m8 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        <holidays :data="{{ $holidays->toJson() }}" store-url="{{ route('holidays.store') }}"></holidays>
                    </div>
                </div>
            </div>
            {{-- actions start  --}}
            <div class="col xl2 m4 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div id="change-salary-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Add Year</span>
                            </span>
                        </div>
                        <div id="change-contract-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Delete Year</span>
                            </span>
                        </div>
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
            months: @json($months)
        }
    </script>
    <script src="{{asset('js/vue/app.js')}}"></script>
@endsection
