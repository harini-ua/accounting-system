@php($model = $model ?? null)
<form name="main-form" method="POST" action="{{ $model ? route('people.update', $model) : route('people.store') }}">
    @csrf
    @if($model)
        @method('PUT')
    @endif
    <div class="row">
        <div class="col s12 m6">
            <h4 class="card-title col s12">{{ __('Main Info') }}</h4>
            <x-input name="name" title="Name" :model="$model"></x-input>
            <x-select name="position_id" title="{{ __('Position') }}" :options="$positions" :model="$model" firstTitle="{{ __('Position') }}"></x-select>
            <x-input name="department" title="Department" :model="$model"></x-input>
            <x-date name="start_date" title="Date of the work beginning" :model="$model"></x-date>
            <x-input name="trial_period" title="{{ __('Trial Period (In Months)') }}" type="number" min="1" max="12" default="{{ config('people.trial_period.value') }}" :model="$model"></x-input>
            <x-input name="salary" title="Salary" :model="$model"></x-input>
            {{--<x-select name="currency" title="{{ __('Currency') }}" :options="$currencies" :model="$model" firstTitle="{{ __('Currency') }}"></x-select>--}}
            <x-textarea name="skills" title="Skills" :model="$model"></x-textarea>
            <x-textarea name="certifications" title="Certifications" :model="$model"></x-textarea>
            @if(!$model)
                <x-select name="salary_type" title="Salary type" :options="$salaryTypes" :model="$model" firstTitle="{{ __('Salary type') }}"></x-select>
                <x-select name="contract_type" title="Type of contract" :options="$contractTypes" :model="$model" firstTitle="{{ __('Type of contract') }}"></x-select>
            @endif
        </div>
        <div class="col s12 m6">
            @if($model)
            <h4 class="col s12 card-title">{{ __('Salary Raising') }}</h4>
            <x-date name="salary_changed_at" title="Date" :model="$model"></x-date>
            <x-input name="last_salary" title="Previous salary" :model="$model"></x-input>
            <x-input name="salary_change_reason" title="Reason" :model="$model"></x-input>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <h4 class="card-title col s12">{{ __('Additional Information') }}</h4>
            <x-checkbox name="growth_plan" title="Professional Growth plan" :model="$model"></x-checkbox>
            <x-checkbox-input checkboxName="tech_lead" :model="$model">
                <x-slot name="checkbox">
                    <x-checkbox name="tech_lead" title="Tech Lead" :model="$model"></x-checkbox>
                </x-slot>
                <x-slot name="input">
                    <x-input name="tech_lead_reward" title="Tech Lead Reward" :model="$model"></x-input>
                </x-slot>
            </x-checkbox-input>

            <x-checkbox-input checkboxName="team_lead" :model="$model">
                <x-slot name="checkbox">
                    <x-checkbox name="team_lead" title="Team Lead" :model="$model"></x-checkbox>
                </x-slot>
                <x-slot name="input">
                    <x-input name="team_lead_reward" title="Team Lead Reward" :model="$model"></x-input>
                </x-slot>
            </x-checkbox-input>

            <x-checkbox-input checkboxName="bonuses" :model="$model">
                <x-slot name="checkbox">
                    <x-checkbox name="bonuses" title="Bonuses" :model="$model"></x-checkbox>
                </x-slot>
                <x-slot name="input">
                    <x-input name="bonuses_reward" title="Bonuses %" :model="$model"></x-input>
                </x-slot>
            </x-checkbox-input>

            <div class="pt-9">
                <x-select name="recruiter_id" title="{{ __('Recruiter') }}" :options="$recruiters" :model="$model" firstTitle="{{ __('Recruiter') }}"></x-select>
            </div>
        </div>
        <div class="col s12 display-flex justify-content-end mt-3">
            <a href="{{ route('people.index') }}" class="btn cancel-btn mr-1">{{ __('Cancel') }}</a>
            <button type="submit" class="btn waves-light waves-effect">{{ __('Save Changes') }}</button>
        </div>
    </div>
</form>
