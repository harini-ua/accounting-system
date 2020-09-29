@php($model = $offer ?? null)
<form id="offer" method="POST"
      action="{{ isset($model) ? route('offers.update', $model) : route('offers.store') }}"
      data-created-item="offer">
    @if(isset($model)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-select name="employee_id" :options="$people" :model="$model" firstTitle="{{ __('Employee') }}" :search="true"></x-select>
        </div>
        <div class="col s12 m6">
            <x-input name="bonuses" title="{{ __('Bonuses (%)') }}" :model="$model" type="number" min="1" max="100"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-date name="start_date" title="{{ __('Date of the work beginning') }}" :model="$model"></x-date>
        </div>
        <div class="col s12 m6">
            <x-input name="trial_period" title="{{ __('Trial Period (in months)') }}" type="number" min="1" max="12" default="{{ config('people.trial_period.value') }}" :model="$model"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-input name="salary" title="{{ __('Salary') }}" :model="$model"></x-input>
        </div>
        <div class="col s12 m6">
            <x-textarea name="additional_conditions" title="{{ __('Additional Conditions') }}" :model="$model"></x-textarea>
        </div>
        <div class="col s12 m6">
            <x-checkbox-input checkboxName="salary_review" :model="$model">
                <x-slot name="checkbox">
                    <x-checkbox name="salary_review" title="Salary Review" :model="$model"></x-checkbox>
                </x-slot>
                <x-slot name="input">
                    <x-input name="sum" title="Sum" :model="$model"></x-input>
                    <x-input name="salary_after_review" title="Salary After Review" :model="$model"></x-input>
                </x-slot>
            </x-checkbox-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <a href="{{ url()->previous() }}" class="cancel-btn btn btn-light mr-1">{{ __('Cancel') }}</a>
                <button type="submit" class="btn waves-effect waves-light">{{ isset($model) ? __('Update') : __('Create') }}</button>
            </div>
        </div>
    </div>
</form>
