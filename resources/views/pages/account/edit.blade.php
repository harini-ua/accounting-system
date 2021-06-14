{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Account')

{{-- page content --}}
@section('content')
    <div class="section">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12" id="account">
                        <form id="accountForm" method="POST" action="{{ route('accounts.update', $model) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="row animate fadeLeft">
                                        <x-input
                                            name="name"
                                            title="Wallet"
                                            :model="$wallet"
                                            disabled="true"
                                        ></x-input>
                                        <x-input
                                            name="name"
                                            title="Account"
                                            :model="$accountType"
                                            disabled="true"
                                        ></x-input>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
