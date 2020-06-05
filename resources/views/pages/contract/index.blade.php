{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Contract'))

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/contracts.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- contract list start -->
    <section id="contracts" class="contracts-lists-wrapper section">
        <h5 class="mb-2">{{__('Contracts')}}</h5>
        <div class="contract-create-btn">
            <a href="{{ route('contracts.create') }}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">{{ __('Add Contract') }}</span>
            </a>
        </div>
        <div class="contracts-list-table">
            <div class="card">
                <div class="card-content">
                    <!-- datatable start -->
                    <div class="responsive-table">
                        {{ $dataTable->table() }}
                    </div>
                    <!-- datatable ends -->
                </div>
            </div>
        </div>
    </section>
    <!-- client list ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/contracts.js')}}"></script>
@endsection