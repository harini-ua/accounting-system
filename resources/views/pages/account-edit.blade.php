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
                                        <div class="col s12 input-field">
                                            <select id="wallet_id" name="wallet_id" disabled>
                                                @foreach ($wallets as $wallet)
                                                    <option {{ $model->position_id == $wallet->id ? 'selected' : '' }}
                                                            value="{{ $wallet->id }}">
                                                        {{ $wallet->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="position_id">Wallet</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <select id="account_type_id" name="account_type_id" disabled>
                                                @foreach ($accountTypes as $accountType)
                                                    <option {{ $model->account_type_id == $accountType->id ? 'selected' : '' }}
                                                            value="{{ $accountType->id }}">
                                                        {{ $accountType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="position_id">Account</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <input id="started_at" name="started_at" type="text" class="datepicker" value="{{ $model->started_at->format('d/m/Y') }}">
                                            <label for="name">Start date</label>
                                            @error('started_at')
                                            <span class="helper-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="start_sum" name="start_sum" type="text" class="" value="{{ $model->start_sum }}">
                                            <label for="name">Start sum</label>
                                            @error('start_sum')
                                            <span class="helper-text">{{ $message }}</span>
                                            @enderror
                                        </div>
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
