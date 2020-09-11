{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "People")

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')

    <section class="person-list-wrapper users-list-wrapper section animate fadeLeft">
        <div class="create-btn invoice-create-btn add-item-btn row">
            <div class="col">
                <a href="{{ route('people.create') }}" class="btn waves-effect waves-light invoice-create z-depth-4">
                    <i class="material-icons">add</i>
                    <span class="hide-on-small-only">Add</span>
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <ul class="tabs">
                        <li class="tab col s12 m6 l3"><a href="#people" class="active" data-people-href="{{ route('people.index') }}">{{ __('People') }}</a></li>
                        <li class="tab col s12 m6 l3"><a href="#former-employees" data-people-href="{{ route('people.former-list') }}">{{ __('Former Employees') }}</a>
                        </li>
                    </ul>
                    <div class="col s12">
                        <div class="users-list-table">
                            <div class="responsive-table overflow-x-auto">
                                <!-- datatable start -->
                                {{ $dataTable->table() }}
                                <!-- datatable ends -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Area Ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/person.js')}}"></script>
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
@endsection
