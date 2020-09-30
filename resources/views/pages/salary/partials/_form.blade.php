@php($model = $salaryPayment ?? null)
@php($isEdit = request()->route()->getName() == 'salary-payments.edit')
<form id="salary-payment-form" method="POST"
      action="{{ $isEdit ? route('salary-payments.update', $model) : route('salary-payments.store') }}"
      data-created-item="offer">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-linked-selects
                firstName="calendar_year_id"
                firstTitle="Year"
                secondName="calendar_month_id"
                secondTitle="Month"
                dataUrl="calendar/year/[id]/months"
                view="components.linked-selects.year-months"
                :options="$calendarYears"
                :model="$model"
            />
        </div>
        <div class="col s12 m6">
            <x-select name="person_id" :options="$people" :model="$model" firstTitle="{{ __('Employee') }}" :search="true"></x-select>
        </div>
    </div>
    <div class="row" data-pjax>
        @if($person)
        <div class="col s12 m6">
            <x-input name="working_days" title="{{ __('Number of working days') }}" :model="$calendarMonth" disabled="true"></x-input>
            <x-input name="worked_days" title="{{ __('Number of worked days') }}" :model="$model"></x-input>
            <x-input name="working_hours" title="{{ __('Number of working hours') }}" :model="$calendarMonth" disabled="true"></x-input>
            <x-input name="worked_hours" title="{{ __('Number of worked hours') }}" :model="$model"></x-input>
            <x-input name="delta_hours" title="{{ __('Delta hours') }}" :model="$model" disabled="true"></x-input>
            <x-input name="earned" title="{{ __('Earned') }}" :model="$model" readonly="true" icon="{{ $symbol }}"></x-input>
            <x-input name="overtime_hours" title="{{ __('Overtime hours') }}" :model="$model"></x-input>
            <x-input name="overtime_pay" title="{{ __('Overtime pay') }}" :model="$model" disabled="true" icon="{{ $symbol }}"></x-input>
            <input type="hidden" name="bonuses" value="{{ $person->actualBonuses ? json_encode($person->actualBonuses, JSON_NUMERIC_CHECK) : '' }}"/>
            <x-input name="vacations" title="{{ __('Vacation') }}" :model="$model" disabled="true"></x-input>
            <x-input name="vacations_hours" type="hidden" :model="$model" disabled="true"></x-input>
            <x-input name="vacation_compensation" title="{{ __('Vacation compensation') }}" :model="$model" disabled="true" icon="{{ $symbol }}"></x-input>
            <x-input name="leads" title="{{ __('Leads') }}" :model="$model" disabled="true"></x-input>
            <x-input name="monthly_bonus" title="{{ __('Monthly bonus') }}" :model="$model" icon="{{ $symbol }}"></x-input>
            <x-input name="fines" title="{{ __('Fines') }}" :model="$model" icon="{{ $symbol }}"></x-input>
            <x-input name="tax_compensation" title="{{ __('Tax compensation') }}" :model="$model" icon="{{ \App\Enums\Currency::symbol(\App\Enums\Currency::UAH) }}"></x-input>
            <x-input name="total_usd" title="{{ __('Total USD') }}" :model="$model" readonly="true" icon="{{ \App\Enums\Currency::symbol(\App\Enums\Currency::USD) }}"></x-input>
            <x-input name="currency" type="hidden" :model="$model"></x-input>
            <x-input name="total_uah" title="{{ __('Total UAH') }}" :model="$model" disabled="true" icon="{{ \App\Enums\Currency::symbol(\App\Enums\Currency::UAH) }}"></x-input>
            <x-linked-selects
                firstName="wallet_id"
                firstTitle="Wallet"
                secondName="account_id"
                secondTitle="Account"
                dataUrl="/wallets/[id]/accounts"
                view="components.linked-selects.wallets-accounts"
                :options="$wallets"
            />
            <x-date name="payment_date" title="{{ __('Payment date') }}"></x-date>
            <x-textarea name="comments" title="{{ __('Comments') }}"></x-textarea>
        </div>
        <div class="col s12 m6">
            <div
                id="person-info"
                class="person-info info-block"
                @if($person && \App\Enums\SalaryType::isHourly($person->salary_type))data-earned-recalc="true"@endif
                data-rate="{{ $person->rate }}"
                data-total-bonuses="{{ $person->totalBonusesUSD }}"
            >
                <h6 class="card-title">{{ __('Employee Info') }}</h6>
                <table class="responsive-table">
                    <tbody>
                    <tr><td>{{ __('Position') }}:</td><td>{{ \App\Enums\Position::getDescription($person->position_id) }}</td></tr>
                    <tr><td>{{ __('Salary type') }}:</td><td>{{ \App\Enums\SalaryType::getDescription($person->salary_type) }}</td></tr>
                    <tr><td>{{ __('Type of contracts') }}:</td><td>{{ \App\Enums\PersonContractType::getDescription($person->contract_type) }}</td></tr>
                    <tr><td>{{ __('Salary') }}:</td><td>{{ \App\Services\Formatter::currency($person->salary, $symbol) }}</td></tr>
                    <tr><td>{{ __('Currency') }}:</td><td>{{ \App\Enums\Currency::getDescription($person->currency) }}</td></tr>
                    <tr><td>{{ __('Hourly rate') }}:</td><td>{{ \App\Services\Formatter::currency($person->rate, $symbol) }}</td></tr>
                    @if($person->actualBonuses)
                    <tr><td colspan="2" class="center-align">{{ __('Bonuses') }}</td></tr>
                        @foreach($person->actualBonuses as $bonus)
                            <tr><td>{{ $bonus->currency }}:</td><td>{{ \App\Services\Formatter::currency($bonus->value, \App\Enums\Currency::symbol($bonus->currency)) }}</td></tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <a href="{{ url()->previous() }}" class="cancel-btn btn btn-light mr-1">{{ __('Cancel') }}</a>
                <button type="submit" class="btn waves-effect waves-light">{{ $isEdit ? __('Update') : __('Create') }}</button>
            </div>
        </div>
    </div>
</form>
