{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Add Expense')

{{-- page content --}}
@section('content')
    <!-- edit start -->
    <div class="section">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <!--  edit form start -->
                        <form method="POST" action="{{ route('expenses.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="row">
                                        <x-date name="plan_date" title="Date"></x-date>
                                        <x-textarea name="purpose" title="Purpose of expense"></x-textarea>
                                        <x-input name="plan_sum" title="Planned"></x-input>
                                        <x-input name="real_sum" title="Real"></x-input>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <x-linked-selects
                                            firstName="wallet_id"
                                            firstTitle="Wallet"
                                            secondName="account_id"
                                            secondTitle="Account"
                                            dataUrl="/wallets/walletAccounts"
                                            view="components.linked-selects.wallets-accounts"
                                            :options="$wallets"
                                        />
                                        <x-select
                                            name="expense_category_id"
                                            title="Category"
                                            :options="$expenseCategories"
                                        ></x-select>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <button type="submit" class="btn indigo mr-1">
                                        Save changes</button>
                                    <a href="{{ route('expenses.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <!-- edit form ends -->
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <!-- edit ends -->
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
@endsection
