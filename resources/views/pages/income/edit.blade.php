{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Income')

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
                        <form method="POST" action="{{ route('incomes.update', $income) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x-linked-selects
                                    firstName="client_id"
                                    firstTitle="Client"
                                    secondName="contract_id"
                                    secondTitle="Contract"
                                    dataUrl="/clients/[id]/contracts"
                                    view="components.linked-selects.clients-contracts"
                                    :options="$clients"
                                    :model="$income"
                                />
                                <x-linked-selects
                                    firstName="wallet_id"
                                    firstTitle="Wallet"
                                    secondName="account_id"
                                    secondTitle="Account"
                                    dataUrl="/wallets/[id]/accounts"
                                    view="components.linked-selects.wallets-accounts"
                                    :options="$wallets"
                                    :model="$income"
                                />
                                <div class="col s12 m6">
                                    <x-date name="plan_date" title="Planning Date" :model="$income"></x-date>
                                </div>
                                <div class="col s12 m6">
                                    <x-input name="plan_sum" title="Planning Sum" :model="$income"></x-input>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <a href="{{ route('incomes.index') }}" class="cancel-btn btn btn-light mr-1">Cancel</a>
                                    <button type="submit" class="btn waves-effect waves-light">
                                        Save changes
                                    </button>
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
