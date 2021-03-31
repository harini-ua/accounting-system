{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Add Money Flow')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

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
                                        />
                                        <x-input name="sum_from" title="Sum"></x-input>
                                        <x-input name="currency_rate" title="Currency Rate"></x-input>
                                        <x-date name="date" title="Date"></x-date>
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
                                            view="components.linked-selects.wallets-accounts-money-flow"
                                            :options="$wallets"
                                        />
                                        <x-input name="sum_to" title="Sum"></x-input>
                                        <x-input name="fee" title="Fee"></x-input>
                                        <x-textarea name="comment" title="Comment"></x-textarea>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <a href="{{ route('money-flows.index') }}" class="btn cancel-btn mr-1">Cancel</a>

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
