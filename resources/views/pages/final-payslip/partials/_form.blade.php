@php($model = $finalPayslip ?? null)
@php($isEdit = request()->route()->getName() == 'final-payslip.create.person')

<form id="final-payslip-form" method="POST"
      action="{{ $isEdit ? route('final-payslip.update', $model) : route('final-payslip.store') }}"
      data-created-item="final-payslip">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-select name="person_id" title="{{ __('Employee') }}" :options="$people" :model="$model" :search="true"></x-select>
        </div>
        <div class="col s12 m6">
            <x-date name="last_working_day" title="{{ __('Last Working Day') }}" :model="$model" readonly="true"></x-date>
        </div>
    </div>
    <div class="row" data-pjax>
        @if($person)
        <div class="col s12 m6">
            <div
                id="person-info"
                class="person-info info-block"
                @if($person && \App\Enums\SalaryType::isHourly($person->salary_type))data-earned-recalc="true"@endif
                data-rate="{{ $person->rate }}"
                data-total-bonuses="{{ $person->totalBonusesUSD }}"
            >
                <h6 class="card-title">{{ __('Employee Info') }}</h6>
                <x-input name="position" title="{{ __('Position') }}" type="text" value="{{ \App\Enums\Position::getDescription($person->position_id) }}" readonly="true"></x-input>
                <x-input name="salary_type" title="{{ __('Salary type') }}" type="text" value="{{ \App\Enums\SalaryType::getDescription($person->salary_type) }}" readonly="true"></x-input>
                <x-input name="contracts" title="{{ __('Type of contracts') }}" type="text" value="{{ \App\Enums\PersonContractType::getDescription($person->contract_type) }}" readonly="true"></x-input>
                <x-input name="salary" title="{{ __('Salary') }}" type="text" value="{{ \App\Services\Formatter::currency($person->salary, \App\Enums\Currency::symbol($person->currency)) }}" readonly="true"></x-input>
                <x-input name="currency" title="{{ __('Currency') }}" type="text" value="{{ \App\Enums\Currency::getDescription($person->currency) }}" readonly="true"></x-input>
                <x-input name="hourly_rate" title="{{ __('Hourly rate') }}" type="text" value="{{ \App\Services\Formatter::currency($person->rate, \App\Enums\Currency::symbol($person->currency)) }}" readonly="true"></x-input>
            </div>
        </div>
        <div class="col s12 m6">
            <h6 class="card-title">{{ __('Final Payslip') }}</h6>

            <x-input name="last_working_day_hidden"
                type="hidden"
                value="{{ \Carbon\Carbon::parse($model->last_working_day)->format(DateTime::ISO8601) }}"
            ></x-input>

            <x-input name="working_days" title="{{ __('Number working days') }}" type="number" :model="$calendarMonth" readonly="true"></x-input>
            <x-input name="worked_days" title="{{ __('Number worked days') }}" type="number" :model="$model" readonly="true"></x-input>

            <x-input name="working_hours" title="{{ __('Number working hours') }}" type="number" :model="$calendarMonth" readonly="true"></x-input>
            <x-input name="worked_hours" title="{{ __('Number worked hours') }}" type="number" :model="$model"></x-input>

            <x-input name="basic_salary" title="{{ __('Basic salary') }}" :model="$model" readonly="true"></x-input>
            <x-input name="earned" title="{{ __('Earned') }}" :model="$model" readonly="true"></x-input>
            <x-input name="bonuses" title="{{ __('Bonuses') }}" :model="$model" readonly="true"></x-input>
            <x-input name="vacation" title="{{ __('Vacation ') . Str::plural('day', $model->vacations) }}" :model="$model" readonly="true"></x-input>
            <x-input name="vacation_compensation" title="{{ __('Vacation compensation') }}" :model="$model" readonly="true" icon="{{ \App\Enums\Currency::symbol($person->currency) }}"></x-input>
            <x-input name="leads" title="{{ __('Leads') }}" :model="$model" readonly="true"></x-input>
            <x-input name="monthly_bonus" title="{{ __('Monthly bonus') }}" :model="$model"></x-input>
            <x-input name="fines" title="{{ __('Fines') }}" :model="$model"></x-input>
            <x-input name="tax_compensation" title="{{ __('Tax compensation') }}" :model="$model" readonly="true"></x-input>
            <x-input name="other_compensation" title="{{ __('Other compensation') }}" :model="$model"></x-input>

            <x-input
                name="total_usd"
                title="{{ __('Total USD') }}"
                :model="$model"
                icon="{{ \App\Enums\Currency::symbol(\App\Enums\Currency::USD) }}"
                readonly="true"
            ></x-input>
            <x-input
                name="total_uah"
                title="{{ __('Total UAH') }}"
                :model="$model"
                icon="{{ \App\Enums\Currency::symbol(\App\Enums\Currency::UAH) }}"
                readonly="true"
            ></x-input>

            <x-textarea name="comments" title="{{ __('Comment') }}" :model="$model"></x-textarea>
            <x-linked-selects
                firstName="wallet_id"
                firstTitle="Wallet"
                secondName="account_id"
                secondTitle="Account"
                dataUrl="/wallets/[id]/accounts"
                view="components.linked-selects.wallets-accounts"
                :options="$wallets"
            ></x-linked-selects>
            <x-checkbox name="paid" title="{{ __('Paid') }}" :model="$model"></x-checkbox>
        </div>
        @endif
    </div>
    <div class="col s12 display-flex justify-content-end mt-3">
        <a href="{{ url()->previous() }}"
           class="btn cancel-btn btn-light mr-1">{{ __('Cancel') }}</a>
        <button type="submit" class="btn">{{ __('Save changes') }}</button>
    </div>
</form>
