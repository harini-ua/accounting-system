{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Person' )

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
            <!-- action  -->
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div id="change-salary-type-button" class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change salary type</span>
                            </a>
                        </div>
                        <div id="change-contract-type-button" class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change type of contract</span>
                            </a>
                        </div>
                        <div id="make-former-button" class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Make former employee</span>
                            </a>
                        </div>
                        <div id="long-vacation-button" class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Long-term vacation</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Back to active employee</span>
                            </a>
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
        </div>
    </section>

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
        <x-input name="long_vacation_compensation" title="Compensation" :model="$model"></x-input>
        <x-date name="long_vacation_finished_at" title="Planning date of coming back to the office" :model="$model"></x-date>
    </x-sidebar-form>

@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
