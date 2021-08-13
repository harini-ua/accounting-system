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
        <div class="row">
            <div class="col xl9 m8 s12">
                <div class="card animate fadeLeft">
                    <div class="card-content invoice-print-area">
                        @include('pages.final-payslip.partials._form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/final-payslip.js')}}"></script>
    <script src="{{asset('js/scripts/checkbox-input.js')}}"></script>
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
