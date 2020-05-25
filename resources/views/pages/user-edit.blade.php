{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','User edit')

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
                                    <div class="col s12 input-field">
                                        <input id="name" name="name" type="text" class="validate" value="{{ $user->name }}"
                                               data-error=".errorTxt1">
                                        <label for="name">Name</label>
                                        @error('name')
                                            <small class="errorTxt1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col s12 input-field">
                                        <input id="email" name="email" type="email" class="validate" value="{{ $user->email }}"
                                               data-error=".errorTxt2">
                                        <label for="email">E-mail</label>
                                        @error('email')
                                            <small class="errorTxt2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="row">
                                    <div class="col s12 input-field">
                                        <select id="position_id" name="position_id">
                                            <option value="">-</option>
                                            @foreach ($positions as $position)
                                                <option {{ $user->position_id == $position->id ? 'selected' : '' }}
                                                        value="{{ $position->id }}">
                                                {{ $position->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="position_id">Position</label>
                                    </div>
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
                                <button type="submit" class="btn indigo">
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
