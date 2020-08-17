{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Person' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/person.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-view-wrapper section">
        <div class="row">
            <div class="col xl9 m8 s12">
                <div class="card animate fadeLeft">
                    <div class="card-content invoice-print-area">
                        @include('pages.person.partials._form')
                    </div>
                </div>
            </div>
            <!-- actions start  -->
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div id="change-salary-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change salary type</span>
                            </span>
                        </div>
                        <div id="change-contract-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change type of contract</span>
                            </span>
                        </div>
                        <div id="make-former-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Make former employee</span>
                            </span>
                        </div>
                        <div id="long-vacation-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Long-term vacation</span>
                            </span>
                        </div>
                        <div id="back-to-active-button" class="invoice-action-btn{{ ! $model->long_vacation_started_at ? ' hide' : '' }}">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Back to active employee</span>
                            </span>
                        </div>
                        <div id="pay-data-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Pay Data</span>
                            </span>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">attach_money</i>
                                <span>Final payslip</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('people.show', $model) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">visibility</i>
                                <span class="text-nowrap">View Person</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- actions end  -->
        </div>
    </section>

    <!-- sidebar forms start  -->
    <x-sidebar-form id="change-salary-type" title="Change salary type" :model="$model">
        <x-date name="salary_type_changed_at" title="Date" :model="$model"></x-date>
        <x-select name="salary_type" title="Salary type" :options="$salaryTypes" :model="$model"></x-select>
    </x-sidebar-form>

    <x-sidebar-form id="change-contract-type" title="Change type of contract" :model="$model">
        <x-date name="contract_type_changed_at" title="Date" :model="$model"></x-date>
        <x-select name="contract_type" title="Type og Contract" :options="$contractTypes" :model="$model"></x-select>
    </x-sidebar-form>

    <x-sidebar-form id="make-former" title="Make former employee" :model="$model">
        <x-date name="quited_at" title="Date" :model="$model"></x-date>
        <x-input name="quit_reason" title="Reason" :model="$model"></x-input>
    </x-sidebar-form>

    <x-sidebar-form id="long-vacation" title="Long-term vacation" :model="$model">
        <x-date name="long_vacation_started_at" title="Date" :model="$model"></x-date>
        <x-input name="long_vacation_reason" title="Reason" :model="$model"></x-input>
        <x-input name="long_vacation_comment" title="Comments" :model="$model"></x-input>
        <div class="col s12 mb-5">
            <x-checkbox-input checkboxName="long_vacation_compensation" :model="$model">
                <x-slot name="checkbox">
                    <x-checkbox name="long_vacation_compensation" title="Compensation" :model="$model"></x-checkbox>
                </x-slot>
                <x-slot name="input">
                    <x-input name="long_vacation_compensation_sum" title="Compensation sum" :model="$model"></x-input>
                </x-slot>
            </x-checkbox-input>
        </div>
        <x-date name="long_vacation_plan_finished_at" title="Planning date of coming back to the office" :model="$model"></x-date>
    </x-sidebar-form>

    <x-sidebar-form id="back-to-active" title="Back to active employee" :model="$model">
        <x-date name="long_vacation_finished_at" title="Date of the work beginning" :model="$model"></x-date>
    </x-sidebar-form>
    <!-- sidebar forms end  -->

    <x-sidebar-form id="pay-data" title="Pay Data" :model="$model">
        <x-input name="code" title="Code" :model="$model"></x-input>
        <x-input name="agreement" title="Agreement" :model="$model"></x-input>
        <x-input name="account_number" title="Account Number" :model="$model"></x-input>
        <x-input name="recipient_bank" title="Recipient Bank" :model="$model"></x-input>
        <x-input name="note_salary_pay" title="Notes For Salary payment" :model="$model"></x-input>
    </x-sidebar-form>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/checkbox-input.js')}}"></script>
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
