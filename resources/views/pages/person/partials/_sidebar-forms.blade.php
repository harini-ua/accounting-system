<!-- sidebar forms start  -->
<x-sidebar-form id="change-salary-type" title="{{ __('Change salary type') }}" :model="$model">
    <x-date name="salary_type_changed_at" title="{{ __('Date') }}" :model="$model"></x-date>
    <x-select name="salary_type" title="{{ __('Salary type') }}" :options="$salaryTypes" :model="$model"></x-select>
</x-sidebar-form>

<x-sidebar-form id="change-contract-type" title="{{ __('Change type of contract') }}" :model="$model">
    <x-date name="contract_type_changed_at" title="{{ __('Date') }}" :model="$model"></x-date>
    <x-select name="contract_type" title="{{ __('Type og Contract') }}" :options="$contractTypes"
              :model="$model"></x-select>
</x-sidebar-form>

<x-sidebar-form id="make-former" title="{{ __('Make former employee') }}" :model="$model">
    <x-date name="quited_at" title="{{ __('Date') }}" :model="$model"></x-date>
    <x-input name="quit_reason" title="{{ __('Reason') }}" :model="$model"></x-input>
</x-sidebar-form>

@php($longVacation = $model->lastLongVacationOrNew(['person_id' => $model->id]))
<x-sidebar-form id="long-vacation" title="{{ __('Long-term vacation') }}" :model="$longVacation" :resource="$model">
    <x-date name="long_vacation_started_at" title="{{ __('Date') }}" :model="$longVacation"></x-date>
    <x-input name="long_vacation_reason" title="{{ __('Reason') }}" :model="$longVacation"></x-input>
    <x-input name="long_vacation_comment" title="{{ __('Comments') }}" :model="$longVacation"></x-input>
    <div class="col s12 mb-5">
        <x-checkbox-input checkboxName="long_vacation_compensation" :model="$longVacation">
            <x-slot name="checkbox">
                <x-checkbox name="long_vacation_compensation" title="{{ __('Compensation') }}"
                            :model="$longVacation"></x-checkbox>
            </x-slot>
            <x-slot name="input">
                <x-input name="long_vacation_compensation_sum" title="{{ __('Compensation sum') }}"
                         :model="$longVacation"></x-input>
            </x-slot>
        </x-checkbox-input>
    </div>
    <x-date name="long_vacation_plan_finished_at" title="{{ __('Planning date of coming back to the office') }}"
            :model="$longVacation"></x-date>
</x-sidebar-form>
@if( $model->lastLongVacation() &&  $model->quited_at)
    <x-sidebar-form id="back-to-active" title="{{ __('Back to active employee') }}" :model="$model">
        <x-date name="long_vacation_finished_at" title="{{ __('Date of the work beginning') }}"
                :model="$model"></x-date>
    </x-sidebar-form>
@endif

<x-sidebar-form id="pay-data" title="{{ __('Pay Data') }}" :model="$model">
    <x-input name="code" title="{{ __('Code') }}" :model="$model"></x-input>
    <x-input name="agreement" title="{{ __('Agreement') }}" :model="$model"></x-input>
    <x-input name="account_number" title="{{ __('Account Number') }}" :model="$model"></x-input>
    <x-input name="recipient_bank" title="{{ __('Recipient Bank') }}" :model="$model"></x-input>
    <x-input name="note_salary_pay" title="{{ __('Notes For Salary payment') }}" :model="$model"></x-input>
</x-sidebar-form>
<!-- sidebar forms end  -->
