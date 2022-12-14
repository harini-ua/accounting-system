{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Add Expense')

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
                    <div class="col s12">
                        <form method="POST" action="{{ route('expenses.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col s12 m6">
                                    <x-date name="plan_date" title="Planning Date" :model="$model"></x-date>
                                    <x-input name="plan_sum" title="Planned" :model="$model"></x-input>
                                    <x-date name="real_date" title="Real Date" :model="$model"></x-date>
                                    <x-input name="real_sum" title="Real" :model="$model"></x-input>
                                </div>
                                <div class="col s12 m6">
                                    <x-select
                                        name="expense_category_id"
                                        title="{{ __('Category') }}"
                                        :options="$expenseCategories"
                                        :model="$model"
                                        firstTitle="{{ __('Category') }}"
                                    ></x-select>
                                    <x-linked-selects
                                        firstName="wallet_id"
                                        firstTitle="Wallet"
                                        secondName="account_id"
                                        secondTitle="Account"
                                        dataUrl="/wallets/[id]/accounts"
                                        view="components.linked-selects.wallets-accounts"
                                        :options="$wallets"
                                        :model="$model"
                                    />
                                    <x-textarea name="purpose" title="Purpose of expense"
                                                :model="$model"></x-textarea>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <a href="{{ route('expenses.index') }}"
                                   class="btn cancel-btn btn-light mr-1">Cancel</a>

                                <button type="submit" class="btn ">
                                    Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
@endsection
