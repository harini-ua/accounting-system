{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit User')

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
<div class="section users-edit">
    <div class="card">
        <div class="card-content">
            <!-- <div class="card-body"> -->
            <div class="row">
                <div class="col s12" id="account">
                    <!-- users edit media object start -->
{{--                    <div class="media display-flex align-items-center mb-2">--}}
{{--                        <a class="mr-2" href="#">--}}
{{--                            <img src="{{asset('images/avatar/avatar-11.png')}}" alt="users avatar" class="z-depth-4 circle"--}}
{{--                                 height="64" width="64">--}}
{{--                        </a>--}}
{{--                        <div class="media-body">--}}
{{--                            <h5 class="media-heading mt-0">Avatar</h5>--}}
{{--                            <div class="user-edit-btns display-flex">--}}
{{--                                <a href="#" class="btn-small indigo">Change</a>--}}
{{--                                <a href="#" class="btn-small btn-light-pink">Reset</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- users edit media object ends -->
                    <!-- users edit account form start -->
                    <form id="accountForm" method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="row">
                                    <x-input name="name" title="Name" :model="$user"></x-input>
                                    <x-input name="email" title="E-mail" :model="$user"></x-input>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="row">
                                    <x-select
                                        name="position_id"
                                        title="Position"
                                        :options="$positions"
                                        :model="$user"
                                    ></x-select>
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