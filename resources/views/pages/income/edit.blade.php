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
<!-- edit start -->
<div class="section">
    <div class="card">
        <div class="card-content">
            <!-- <div class="card-body"> -->
            <div class="row">
                <div class="col s12" id="account">
                    <!-- form start -->
                    <form method="POST" action="{{ route('incomes.update', $income) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="divider mt-2 mb-2"></div>
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
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="divider mt-2 mb-2"></div>
                                <div class="row">
                                    <x-date name="plan_date" title="Planning Date" :model="$income"></x-date>
                                    <x-input name="plan_sum" title="Planning Sum" :model="$income"></x-input>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <button type="submit" class="btn indigo mr-1">
                                    Save changes</button>
                                <a href="{{ route('incomes.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <!-- form ends -->
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<!-- edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    @stack('components-scripts')
@endsection
