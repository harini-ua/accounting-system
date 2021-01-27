{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Account')

{{-- page content --}}
@section('content')
    <!-- users edit start -->
    <div class="section">
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
                                    <div class="row animate fadeLeft">
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
                                <div class="col s12 m6 animate fadeRight">
                                    <div class="row">
                                        <x-date name="started_at" title="Start date" :model="$model"></x-date>
                                        <x-input name="balance" title="Balance" :model="$model"></x-input>

                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <a href="{{ route('accounts.index') }}" class="btn btn-light cancel-btn mr-1">Cancel</a>

                                    <button type="submit" class="btn waves-effect waves-light">
                                        Save changes</button>
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
