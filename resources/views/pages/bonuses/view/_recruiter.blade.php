{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Bonus for " . $person->name . " (".\App\Enums\Position::getDescription($person->position_id).")")

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
            <div class="holidays-wrap col xl9 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        content
                    </div>
                </div>
            </div>
            <div class="col xl3 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div class="invoice-action-btn">
{{--                            <a href="{{ route('bonuses.edit', $person->bonus) }}" class="btn-block indigo btn waves-effect waves-light">--}}
{{--                                <span>{{ __('Edit Bonus') }}</span>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row invoice-view-wrapper">
            <div class="holidays-wrap col xl9 s12 animate fadeLeft">
                <div class="card">
                    <div class="card-content">
                        content
                    </div>
                </div>
            </div>
            <div class="col xl2 s12">

            </div>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    {{-- --}}
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/vue/app.js')}}"></script>
@endsection
