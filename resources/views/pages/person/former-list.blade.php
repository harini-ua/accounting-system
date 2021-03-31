{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Former Employees")

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
    <div class="create-btn invoice-create-btn add-item-btn">
        <a href="{{ route('people.create') }}" class="btn waves-effect waves-light invoice-create">
            <i class="material-icons">add</i>
            <span class="hide-on-small-only">Add</span>
        </a>
    </div>
    <section class="person-list-wrapper users-list-wrapper section animate fadeLeft">
        <div class="card mt-0">
            <div class="card-content">
                <div class="row">
                    <ul class="tabs">
                        <li class="tab col s12 m6 l3"><a href="#people"
                                                         data-people-href="{{ route('people.index') }}">{{ __('People') }}</a>
                        </li>
                        <li class="tab col s12 m6 l3"><a href="#former-employees" class="active"
                                                         data-people-href="{{ route('people.former-list') }}">{{ __('Former Employees') }}</a>
                        </li>
                    </ul>
                    <div class="col s12">
                        <div class="users-list-table">
                            <div class="responsive-table overflow-x-auto">
                            {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

