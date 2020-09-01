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

@php($longVacation = $model->lastLongVacationOrNew(['person_id' => $model->id]))
<x-sidebar-form id="long-vacation" title="Long-term vacation" :model="$longVacation" :resource="$model">
    <x-date name="long_vacation_started_at" title="Date" :model="$longVacation"></x-date>
    <x-input name="long_vacation_reason" title="Reason" :model="$longVacation"></x-input>
    <x-input name="long_vacation_comment" title="Comments" :model="$longVacation"></x-input>
    <div class="col s12 mb-5">
        <x-checkbox-input checkboxName="long_vacation_compensation" :model="$longVacation">
            <x-slot name="checkbox">
                <x-checkbox name="long_vacation_compensation" title="Compensation" :model="$longVacation"></x-checkbox>
            </x-slot>
            <x-slot name="input">
                <x-input name="long_vacation_compensation_sum" title="Compensation sum" :model="$longVacation"></x-input>
            </x-slot>
        </x-checkbox-input>
    </div>
    <x-date name="long_vacation_plan_finished_at" title="Planning date of coming back to the office" :model="$longVacation"></x-date>
</x-sidebar-form>

<x-sidebar-form id="back-to-active" title="Back to active employee" :model="$model">
    <x-date name="long_vacation_finished_at" title="Date of the work beginning" :model="$model"></x-date>
</x-sidebar-form>

<x-sidebar-form id="pay-data" title="Pay Data" :model="$model">
    <x-input name="code" title="Code" :model="$model"></x-input>
    <x-input name="agreement" title="Agreement" :model="$model"></x-input>
    <x-input name="account_number" title="Account Number" :model="$model"></x-input>
    <x-input name="recipient_bank" title="Recipient Bank" :model="$model"></x-input>
    <x-input name="note_salary_pay" title="Notes For Salary payment" :model="$model"></x-input>
</x-sidebar-form>
<!-- sidebar forms end  -->
