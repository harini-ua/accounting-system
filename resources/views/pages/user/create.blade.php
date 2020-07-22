{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Add User')

{{-- vendor styles --}}
@section('vendor-style')

@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- users edit start -->
    <div class="section users-edit animate fadeUp">
        <div class="card">
            <div class="card-content">
                <!-- <div class="card-body"> -->
                <div class="row">
                    <div class="col s12" id="account">
                        <form id="accountForm" method="POST" action="{{ route('users.store') }}">
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
                                            @error('password')
                                            <small class="errorTxt3">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <x-select-old
                                            name="position_id"
                                            title="Position"
                                            :options="$positions"
                                        ></x-select-old>
                                    </div>
                                </div>
                                {{--                            <div class="col s12">--}}
                                {{--                                <table class="mt-1">--}}
                                {{--                                    <thead>--}}
                                {{--                                    <tr>--}}
                                {{--                                        <th>Module Permission</th>--}}
                                {{--                                        <th>Read</th>--}}
                                {{--                                        <th>Write</th>--}}
                                {{--                                        <th>Create</th>--}}
                                {{--                                        <th>Delete</th>--}}
                                {{--                                    </tr>--}}
                                {{--                                    </thead>--}}
                                {{--                                    <tbody>--}}
                                {{--                                    <tr>--}}
                                {{--                                        <td>Users</td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" checked />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" checked />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                                {{--                                    <tr>--}}
                                {{--                                        <td>Articles</td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" checked />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" checked />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                                {{--                                    <tr>--}}
                                {{--                                        <td>Staff</td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" checked />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" checked />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <label>--}}
                                {{--                                                <input type="checkbox" />--}}
                                {{--                                                <span></span>--}}
                                {{--                                            </label>--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                                {{--                                    </tbody>--}}
                                {{--                                </table>--}}
                                {{--                                <!-- </div> -->--}}
                                {{--                            </div>--}}
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <button type="submit" class="btn indigo mr-1">
                                        Save changes</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <!-- users edit account form ends -->
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <!-- users edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')

@endsection

{{-- page scripts --}}
@section('page-script')

@endsection
