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
                                        <x-linked-selects
                                            firstName="wallet_from_id"
                                            firstTitle="Wallet"
                                            secondName="account_from_id"
                                            secondTitle="Account"
                                            dataUrl="/wallets/walletAccounts"
                                            view="components.linked-selects.wallets-accounts-money-flow"
                                            :options="$wallets"
                                        />
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
                                        <x-linked-selects
                                            firstName="wallet_to_id"
                                            firstTitle="Wallet"
                                            secondName="account_to_id"
                                            secondTitle="Account"
                                            dataUrl="/wallets/walletAccounts"
                                            view="components.linked-selects.wallets-accounts-money-flow"
                                            :options="$wallets"
                                        />
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
    @stack('components-scripts')
@endsection
