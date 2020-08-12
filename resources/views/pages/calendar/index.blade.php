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
            <div class="col xl9 m8 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        <div class="responsive-table">
                            <calendar-table :data="{{ $firstQuarter }}" quarter-name="I quarter"></calendar-table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- content end --}}
            {{-- actions start  --}}
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div id="change-salary-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change salary type</span>
                            </span>
                        </div>
                        <div id="change-contract-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change type of contract</span>
                            </span>
                        </div>
                        <div id="make-former-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Make former employee</span>
                            </span>
                        </div>
                        <div id="long-vacation-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Long-term vacation</span>
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
    <script src="{{asset('js/vue/app.js')}}"></script>
@endsection
