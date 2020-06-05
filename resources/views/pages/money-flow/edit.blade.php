{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Money Flow edit')

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
                    <form id="accountForm" method="POST" action="{{ route('money-flows.update', $model) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col s12 m6">
                                <h5>From:</h5>
                                <div class="divider mt-2 mb-2"></div>
                                <div class="row">
                                    <div class="col s12 input-field">
                                        <select id="wallet_from_id" name="wallet_from_id" class="linked">
                                            @foreach ($wallets as $wallet)
                                            <option {{ $model->accountFrom->wallet_id == $wallet->id ? 'selected' : '' }}
                                                value="{{ $wallet->id }}">
                                                {{ $wallet->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="wallet_from_id">Wallet</label>
                                    </div>
                                    <div class="col s12 input-field">
                                        <select id="account_from_id" name="account_from_id" data-linked="wallet_from_id">
                                            @foreach ($wallets->find($model->accountFrom->wallet_id)->accounts as $account)
                                            <option {{ $model->account_from_id == $account->id ? 'selected' : '' }}
                                                value="{{ $account->id }}">
                                                {{ $account->accountType->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="account_from_id">Account</label>
                                    </div>
                                    <x-date name="date" title="Date" :model="$model"></x-date>
                                    <x-input name="sum_from" title="Sum" :model="$model"></x-input>
                                    <x-input name="currency_rate" title="Currency Rate" :model="$model"></x-input>
                                    <x-input name="fee" title="Fee" :model="$model"></x-input>
                                    <x-textarea name="comment" title="Comment" :model="$model"></x-textarea>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <h5>To:</h5>
                                <div class="divider mt-2 mb-2"></div>
                                <div class="row">
                                    <div class="col s12 input-field">
                                        <select id="wallet_to_id" name="wallet_to_id" class="linked">
                                            @foreach ($wallets as $wallet)
                                                <option {{ $model->accountTo->wallet_id == $wallet->id ? 'selected' : '' }}
                                                        value="{{ $wallet->id }}">
                                                    {{ $wallet->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="wallet_to_id">Wallet</label>
                                    </div>
                                    <div class="col s12 input-field">
                                        <select id="account_to_id" name="account_to_id" data-linked="wallet_to_id">
                                            @foreach ($wallets->find($model->accountTo->wallet_id)->accounts as $account)
                                                <option {{ $model->account_to_id == $account->id ? 'selected' : '' }}
                                                        value="{{ $account->id }}">
                                                    {{ $account->accountType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="account_to_id">Account</label>
                                    </div>
                                    <x-input name="sum_to" title="Sum" :model="$model"></x-input>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <button type="submit" class="btn indigo">
                                    Save changes</button>
                                <a href="{{ route('money-flows.index') }}" class="btn btn-light">Cancel</a>
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
    <script src="{{ asset('js/scripts/money-flows.js') }}"></script>
@endsection
