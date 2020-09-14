{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Person' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/person.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="person-edit-wrapper invoice-view-wrapper section">

{{--        @include('pages.person.partials._slide-down-forms')--}}

{{--        <div class="create-btn add-item-btn slide-down-btn">--}}
{{--            <a href="#" class="waves-effect waves-light btn">--}}
{{--                <i class="material-icons">add</i>--}}
{{--                <span class="hide-on-small-only">Add</span>--}}
{{--            </a>--}}
{{--        </div>--}}

        <div class="row">
            <div class="col xl9 m8 s12">
                @include('pages.person.partials._slide-down-forms')
                <div class="card animate fadeLeft">
                    <div class="card-content invoice-print-area">
                        @include('pages.person.partials._form')
                    </div>
                </div>
            </div>
            @include('pages.person.partials._actions', ['isEdit' => true])
        </div>
    </div>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/checkbox-input.js')}}"></script>
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
