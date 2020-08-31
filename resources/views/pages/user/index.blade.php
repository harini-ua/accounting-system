{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Users List')

{{-- vendors styles --}}
@section('vendor-style')
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
    <!-- users list start -->
    <section class="users-list-wrapper section animate fadeUp">
        <div class="card slide-down-block">
            <div class="card-content">

                <div>
                    <!-- form start -->
                    <form class="handle-submit-form" id="accountForm" name="user-form" method="POST"
                          action="{{ route('users.store') }}" data-created-item="user">
                        @csrf
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="row">
                                    <x-input name="name" title="Name"></x-input>
                                    <x-input name="email" title="E-mail"></x-input>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="row">
                                    <div class="col s12 input-field">
                                        <input id="password" name="password" type="password" class="validate" value="{{ old('password') }}"
                                               data-error=".errorTxt1">
                                        <label for="password">Password</label>
                                        <span class="error-span"></span>
                                    </div>
                                    <x-select
                                            name="position_id"
                                            title="Position"
                                            :options="$positions"
                                    ></x-select>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-light mr-1 chanel-btn slide-up-btn">Cancel</button>
                                <button type="submit" class="btn waves-effect waves-light">
                                    Save changes</button>
                            </div>
                        </div>
                    </form>
                    <!-- form start end-->
                </div>
            </div>
        </div>
        <div class="create-btn add-item-btn slide-down-btn">
            <a href="#" class="waves-effect waves-light btn">
                <i class="material-icons">add</i>
                <span class="hide-on-small-only">Add</span>
            </a>
        </div>
        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="responsive-table">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
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
@endsection
