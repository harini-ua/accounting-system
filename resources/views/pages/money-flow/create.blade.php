{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Add Money Flow')

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
                        <form id="accountForm" method="POST" action="{{ route('money-flows.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col s12 m6">
                                    <h5>From:</h5>
                                    <div class="divider mt-2 mb-2"></div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <select id="wallet_from_id" name="wallet_from_id" class="linked">
                                                @foreach ($wallets as $wallet)
                                                    <option {{ old('wallet_from_id') == $wallet->id ? 'selected' : '' }}
                                                            value="{{ $wallet->id }}">
                                                        {{ $wallet->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="wallet_from_id">Wallet</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <select id="account_from_id" name="account_from_id" data-linked="wallet_from_id">
                                                @php($wallet = old('wallet_from_id') ? $wallets->find(old('wallet_from_id')) : $wallets->first())
                                                @foreach ($wallet->accounts as $account)
                                                    <option {{ old('account_from_id') == $account->id ? 'selected' : '' }}
                                                            value="{{ $account->id }}">
                                                        {{ $account->accountType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="account_from_id">Account</label>
                                        </div>
                                        <x-date name="date" title="Date"></x-date>
                                        <x-input name="sum_from" title="Sum"></x-input>
                                        <x-input name="currency_rate" title="Currency Rate"></x-input>
                                        <x-input name="fee" title="Fee"></x-input>
                                        <x-textarea name="comment" title="Comment"></x-textarea>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <h5>To:</h5>
                                    <div class="divider mt-2 mb-2"></div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <select id="wallet_to_id" name="wallet_to_id" class="linked">
                                                @foreach ($wallets as $wallet)
                                                    <option {{ old('wallet_to_id') == $wallet->id ? 'selected' : '' }}
                                                            value="{{ $wallet->id }}">
                                                        {{ $wallet->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="wallet_to_id">Wallet</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <select id="account_to_id" name="account_to_id" data-linked="wallet_to_id">
                                                @php($wallet = old('wallet_to_id') ? $wallets->find(old('wallet_to_id')) : $wallets->first())
                                                @foreach ($wallet->accounts as $account)
                                                    <option {{ old('account_to_id') == $account->id ? 'selected' : '' }}
                                                            value="{{ $account->id }}">
                                                        {{ $account->accountType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="account_to_id">Account</label>
                                        </div>
                                        <x-input name="sum_to" title="Sum"></x-input>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <button type="submit" class="btn indigo mr-1">
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

{{-- page scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/money-flows.js') }}"></script>
@endsection
