<!-- form start -->
@php($model = $model ?? null)
<form name="main-form" method="POST" action="{{ $model ? route('people.update', $model) : route('people.store') }}">
    @csrf
    @if($model)
        @method('PUT')
    @endif
    <div class="row">
        {{-- main info col start --}}
        <div class="col s12 m6">
            <div class="row">
                {{-- main info start --}}
                <h4 class="card-title">{{ __('Main Info') }}</h4>
                <x-input name="name" title="Name" :model="$model"></x-input>
                <x-select name="position_id" title="Position" :options="$positions" :model="$model"></x-select>
                <x-input name="department" title="Department" :model="$model"></x-input>
                <x-date name="start_date" title="Date of the work beginning" :model="$model"></x-date>
                <x-input name="salary" title="Salary" :model="$model"></x-input>
                <x-select name="currency" title="Currency" :options="$currencies" :model="$model"></x-select>
                <x-textarea name="skills" title="Skills" :model="$model"></x-textarea>
                <x-textarea name="certifications" title="Certifications" :model="$model"></x-textarea>
                @if(!$model)
                    <x-select name="salary_type" title="Salary type" :options="$salaryTypes" :model="$model"></x-select>
                    <x-select name="contract_type" title="Type of contract" :options="$contractTypes" :model="$model"></x-select>
                @endif
                {{-- main info end --}}
            </div>
        </div>
        {{-- main info col end --}}
        <div class="col s12 m6">
            {{-- add info start --}}
            <h4 class="card-title">{{ __('Additional information') }}</h4>
            <div class="row">
                <x-checkbox name="growth_plan" title="Professional Growth plan" :model="$model"></x-checkbox>
            </div>

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

            <div class="row mt-8">
                <x-select name="recruiter_id" title="Recruiter" :options="$recruiters" :model="$model" firstTitle="Recruiter"></x-select>
            </div>
            {{-- add info end --}}
            @if($model)
                {{-- salary raising start --}}
                <div class="divider mb-5 mt-8"></div>
                <div class="row">
                    <h4 class="card-title">{{ __('Salary raising') }}</h4>
                    <x-date name="salary_changed_at" title="Date" :model="$model"></x-date>
                    <x-input name="last_salary" title="Previous salary" :model="$model"></x-input>
                    <x-input name="salary_change_reason" title="Reason" :model="$model"></x-input>
                </div>
                {{-- salary raising end --}}
            @endif
        </div>
        <div class="col s12 display-flex justify-content-end mt-3">
            <a href="{{ route('people.index') }}" class="btn chanel-btn mr-1">Cancel</a>

            <button type="submit" class="btn waves-light waves-effect">Save changes</button>
        </div>
    </div>
</form>
<!-- form ends -->
