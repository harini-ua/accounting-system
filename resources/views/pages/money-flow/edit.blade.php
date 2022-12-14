{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Money Flow')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12" id="account">
                    <form id="accountForm" method="POST" action="{{ route('money-flows.update', $moneyFlow) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col s12 m6">
                                <h5 class="indigo-text">From:</h5>
                                <div class="row">
                                    <x-linked-selects
                                        firstName="wallet_from_id"
                                        firstTitle="Wallet"
                                        secondName="account_from_id"
                                        secondTitle="Account"
                                        dataUrl="/wallets/[id]/accounts"
                                        view="components.linked-selects.wallets-accounts-money-flow"
                                        :options="$wallets"
                                        :model="$moneyFlow"
                                    />
                                    <x-date name="date" title="Date" :model="$moneyFlow"></x-date>
                                    <x-input name="sum_from" title="Sum" :model="$moneyFlow"></x-input>
                                    <x-input name="currency_rate" title="Currency Rate" :model="$moneyFlow"></x-input>
                                    <x-date name="date" title="Date" :model="$moneyFlow"></x-date>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <h5 class="purple-text">To:</h5>
                                <div class="row">
                                    <x-linked-selects
                                        firstName="wallet_to_id"
                                        firstTitle="Wallet"
                                        secondName="account_to_id"
                                        secondTitle="Account"
                                        dataUrl="/wallets/[id]/accounts"
                                        view="components.linked-selects.wallets-accounts-money-flow-to"
                                        :options="$wallets"
                                        :model="$moneyFlow"
                                    />
                                    <x-input name="sum_to" title="Sum" :model="$moneyFlow"></x-input>
                                    <x-input name="fee" title="Fee" :model="$moneyFlow"></x-input>
                                    <x-textarea name="comment" title="Comment" :model="$moneyFlow"></x-textarea>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <a href="{{ route('money-flows.index') }}" class="btn cancel-btn mr-1">Cancel</a>
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

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection


{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
@endsection
