{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','View Person' )

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
                        {{-- content start --}}
                        <!-- header section -->
                        <div class="row invoice-date-number">
                            <div class="col xl8 s12 offset-xl4">
                                <div class="invoice-date display-flex align-items-center flex-wrap">
                                    <div class="mr-3">
                                        <small>{{ __('Date of the work beginning') }}:</small>
                                        <span>{{ $person->start_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- logo and title start --}}
                        <div class="row mt-3">
                            <div class="col m6 s12">
                                <h4 class="indigo-text">{{ __('Person') }}</h4>
                                <span>{{ $person->name }}</span>
                            </div>
                        </div>
                        <div class="divider mb-3 mt-3"></div>
                        {{-- logo and title start --}}
                        {{-- main-info start --}}
                        <div class="main-info info-block">
                            <h6 class="card-title">{{ __('Main Info') }}</h6>
                            <table class="responsive-table">
                                <tbody>
                                <tr><td>{{ __('Position') }}:</td><td>{{ \App\Enums\Position::getDescription($person->position_id) }}</td></tr>
                                @if($person->department)<tr><td>{{ __('Department') }}:</td><td>{{ $person->department }}</td></tr>@endif
                                <tr><td>{{ __('Salary') }}:</td><td>{{ \App\Services\Formatter::currency($person->salary, $symbol) }}</td></tr>
                                <tr><td>{{ __('Hourly rate') }}:</td><td>{{ \App\Services\Formatter::currency($person->rate, $symbol) }}</td></tr>
                                @if($person->skills)<tr><td>{{ __('Skills') }}:</td><td>{{ $person->skills }}</td></tr>@endif
                                @if($person->certifications)<tr><td>{{ __('Certifications') }}:</td><td>{{ $person->certifications }}</td></tr>@endif
                                <tr><td>{{ __('Salary type') }}:</td><td data-name="salary_type">{{ \App\Enums\SalaryType::getDescription($person->salary_type) }}</td></tr>
                                <tr{{ empty($person->contract_type_changed_at) ? ' class=hide' : '' }}><td>{{ __('Date of change Salary type') }}:</td><td data-name="salary_type_changed_at">{{ $person->salary_type_changed_at }}</td></tr>
                                <tr><td>{{ __('Type of contracts') }}:</td><td data-name="contract_type">{{ \App\Enums\PersonContractType::getDescription($person->contract_type) }}</td></tr>
                                <tr{{ empty($person->contract_type_changed_at) ? ' class=hide' : '' }}><td>{{ __('Date of change type of contract') }}:</td><td data-name="contract_type_changed_at">{{ $person->contract_type_changed_at }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- main-info end --}}
                        {{-- additional-info start --}}
                        <div class="additional-info info-block mt-3">
                            <h6 class="card-title">{{ __('Additional information') }}</h6>
                            <table class="responsive-table">
                                <tbody>
                                <tr><td>{{ __('Professional Growth plan') }}:</td><td>@if($person->growth_plan)<i class="material-icons">done</i>@else<i class="material-icons">clear</i>@endif</td><td></td></tr>
                                <tr>
                                    <td>{{ __('Tech Lead') }}:</td>
                                    <td>@if($person->tech_lead)<i class="material-icons">done</i>@else<i class="material-icons">clear</i>@endif</td>
                                    <td>@if($person->tech_lead_reward){{ \App\Services\Formatter::currency($person->tech_lead_reward, $symbol) }}@endif</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Team Lead') }}:</td>
                                    <td>@if($person->team_lead)<i class="material-icons">done</i>@else<i class="material-icons">clear</i>@endif</td>
                                    <td>@if($person->team_lead_reward){{ \App\Services\Formatter::currency($person->team_lead_reward, $symbol) }}@endif</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Bonuses') }}:</td>
                                    <td>@if($person->bonuses)<i class="material-icons">done</i>@else<i class="material-icons">clear</i>@endif</td>
                                    <td>@if($person->bonuses_reward){{ \App\Services\Formatter::currency($person->bonuses_reward, '%') }}@endif</td>
                                </tr>
                                @if($person->recruiter)<tr><td>{{ __('Recruiter') }}:</td><td>{{ $person->recruiter->name }}</td><td></td></tr>@endif
                                </tbody>
                            </table>
                        </div>
                        {{-- additional-info end --}}
                        @if($person->salary_changed_at)
                            {{-- salary-changed-info start --}}
                            <div class="salary-changed-info info-block mt-3">
                                <h6 class="card-title">{{ __('Salary changed') }}</h6>
                                <table class="responsive-table">
                                    <tbody>
                                    @if($person->salary_changed_at)<tr><td>{{ __('Date of change salary') }}:</td><td>{{ $person->salary_changed_at }}</td></tr>@endif
                                    @if($person->salary_change_reason)<tr><td>{{ __('Reason of change salary') }}:</td><td>{{ $person->salary_change_reason }}</td></tr>@endif
                                    @if($person->last_salary)<tr><td>{{ __('Previous salary') }}:</td><td>{{ \App\Services\Formatter::currency($person->last_salary, $symbol) }}</td></tr>@endif
                                    </tbody>
                                </table>
                            </div>
                            {{-- salary-changed-info end --}}
                        @endif
                        {{-- long-vacation-info start --}}
                        <div class="long-vacation-info info-block mt-3{{ empty($person->long_vacation_started_at) && empty($person->long_vacation_finished_at) ? ' hide' : '' }}">
                            <h6 class="card-title">{{ __('Long-term vacation') }}</h6>
                            <table class="responsive-table">
                                <tbody>
                                    <tr{{ empty($person->long_vacation_started_at) ? ' class=hide' : '' }}>
                                        <td>{{ __('Date of beginning') }}:</td>
                                        <td data-name="long_vacation_started_at">{{ $person->long_vacation_started_at }}</td>
                                    </tr>
                                    <tr{{ empty($person->long_vacation_reason) ? ' class=hide' : '' }}>
                                        <td>{{ __('Reason') }}:</td>
                                        <td data-name="long_vacation_reason">{{ $person->long_vacation_reason }}</td>
                                    </tr>
                                    <tr{{ empty($person->long_vacation_comment) ? ' class=hide' : '' }}>
                                        <td>{{ __('Comments') }}:</td>
                                        <td data-name="long_vacation_comment">{{ $person->long_vacation_comment }}</td>
                                    </tr>
                                    <tr{{ empty($person->long_vacation_compensation_sum) ? ' class=hide' : '' }}>
                                        <td>{{ __('Compensation') }}:</td>
                                        <td data-name="long_vacation_compensation_sum" data-currency="{{ $person->currency }}">
                                            {{ \App\Services\Formatter::currency($person->long_vacation_compensation_sum, $symbol) }}
                                        </td>
                                    </tr>
                                    <tr{{ empty($person->long_vacation_plan_finished_at) ? ' class=hide' : '' }}>
                                        <td>{{ __('Planning date of coming back to the office') }}:</td>
                                        <td data-name="long_vacation_plan_finished_at">{{ $person->long_vacation_plan_finished_at }}</td>
                                    </tr>
                                    <tr{{ empty($person->long_vacation_finished_at) ? ' class=hide' : '' }}>
                                        <td>{{ __('Date of the work beginning') }}:</td>
                                        <td data-name="long_vacation_finished_at">{{ $person->long_vacation_finished_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- long-vacation-info end --}}
                        {{-- quit-info start --}}
                        <div class="quit-info info-block mt-3{{ empty($person->quited_at) ? ' hide' : '' }}">
                            <h6 class="card-title">{{ __('Quit information') }}</h6>
                            <table class="responsive-table">
                                <tbody>
                                    <tr{{ empty($person->quited_at) ? ' class=hide' : '' }}>
                                        <td>{{ __('Date') }}:</td>
                                        <td data-name="quited_at">{{ $person->quited_at }}</td>
                                    </tr>
                                    <tr{{ empty($person->quit_reason) ? ' class=hide' : '' }}>
                                        <td>{{ __('Reason') }}:</td>
                                        <td data-name="quit_reason">{{ $person->quit_reason }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- quit-info end --}}
                        {{-- content end --}}
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
                        <div id="back-to-active-button" class="invoice-action-btn{{ ! $person->long_vacation_started_at && ! $person->quited_at ? ' hide' : '' }}">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Back to active employee</span>
                            </span>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">attach_money</i>
                                <span>Final payslip</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('people.edit', $person) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">edit</i>
                                <span class="text-nowrap">Edit Person</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- actions end  -->
        </div>
    </section>

    <!-- sidebar forms start  -->
    <x-sidebar-form id="change-salary-type" title="Change salary type" :model="$person">
        <x-date name="salary_type_changed_at" title="Date" :model="$person"></x-date>
        <x-select name="salary_type" title="Salary type" :options="$salaryTypes" :model="$person"></x-select>
    </x-sidebar-form>

    <x-sidebar-form id="change-contract-type" title="Change type of contract" :model="$person">
        <x-date name="contract_type_changed_at" title="Date" :model="$person"></x-date>
        <x-select name="contract_type" title="Type og Contract" :options="$contractTypes" :model="$person"></x-select>
    </x-sidebar-form>

    <x-sidebar-form id="make-former" title="Make former employee" :model="$person">
        <x-date name="quited_at" title="Date" :model="$person"></x-date>
        <x-input name="quit_reason" title="Reason" :model="$person"></x-input>
    </x-sidebar-form>

    <x-sidebar-form id="long-vacation" title="Long-term vacation" :model="$person">
        <x-date name="long_vacation_started_at" title="Date" :model="$person"></x-date>
        <x-input name="long_vacation_reason" title="Reason" :model="$person"></x-input>
        <x-input name="long_vacation_comment" title="Comments" :model="$person"></x-input>
        <div class="col s12 mb-5">
            <x-checkbox-input checkboxName="long_vacation_compensation" :model="$person">
                <x-slot name="checkbox">
                    <x-checkbox name="long_vacation_compensation" title="Compensation" :model="$person"></x-checkbox>
                </x-slot>
                <x-slot name="input">
                    <x-input name="long_vacation_compensation_sum" title="Compensation sum" :model="$person"></x-input>
                </x-slot>
            </x-checkbox-input>
        </div>
        <x-date name="long_vacation_plan_finished_at" title="Planning date of coming back to the office" :model="$person"></x-date>
    </x-sidebar-form>

    <x-sidebar-form id="back-to-active" title="Back to active employee" :model="$person">
        <x-date name="long_vacation_finished_at" title="Date of the work beginning" :model="$person"></x-date>
    </x-sidebar-form>
    <!-- sidebar forms end  -->

@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/checkbox-input.js')}}"></script>
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
