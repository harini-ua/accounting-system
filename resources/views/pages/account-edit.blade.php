{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Account edit')

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
                        <!-- users edit account form start -->
                        <form id="accountForm" method="POST" action="{{ route('accounts.update', $model) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="row">
                                        <x-select
                                            name="wallet_id"
                                            title="Wallet"
                                            :options="$wallets"
                                            :model="$model"
                                            disabled="true"
                                        ></x-select>
                                        <x-select
                                            name="account_type_id"
                                            title="Account"
                                            :options="$accountTypes"
                                            :model="$model"
                                            disabled="true"
                                        ></x-select>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <x-date name="started_at" title="Start date" :model="$model"></x-date>
                                        <x-input name="start_sum" title="Start sum" :model="$model"></x-input>
                                        <div class="col s12 input-field">
                                            <div class="switch">
                                                <label>
                                                    Inactive
                                                    <input id="status" name="status" type="checkbox" {{ $model->status ? 'checked' : '' }} value="1">
                                                    <span class="lever"></span>
                                                    Active
                                                </label>
                                            </div>
                                            @error('status')
                                            <span class="helper-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <button type="submit" class="btn indigo">
                                        Save changes</button>
                                    <a href="{{ route('accounts.index') }}" class="btn btn-light">Cancel</a>
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