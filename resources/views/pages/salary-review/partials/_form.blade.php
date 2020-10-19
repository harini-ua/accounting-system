@php($model = $salaryReview ?? null)
<form id="salary-review"
      method="POST"
      action="{{ isset($model) ? route('salary-reviews.update', $model) : route('salary-reviews.store') }}"
      data-created-item="salaryReview"
>
    @if(isset($model)) @method('PUT') @endif
    @csrf
    <input type="hidden" name="type" value="{{ \App\Enums\SalaryReviewType::getKey(\App\Enums\SalaryReviewType::ACTUAL) }}">
    <div class="row">
        <div class="col s12 m6">
            <x-select name="person_id" title="{{ __('Person') }}" :options="$people" :model="$model" firstTitle="{{ __('Person') }}" :search="true"></x-select>
        </div>
        <div class="col s12 m6">
            <x-date name="date" title="{{ __('Date') }}" :model="$model"></x-date>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-select name="reason" title="{{ __('Reason') }}"  :options="$reasons" :model="$model" firstTitle="{{ __('Reason') }}"></x-select>
        </div>
        <div class="col s12 m6">
            <x-select name="prof_growth" title="{{ __('Profession Growth') }}" :disabled="true" :options="$profGrowthTypes" :model="$model" firstTitle="{{ __('Profession Growth') }}"></x-select>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-input name="sum" title="{{ __('Sum') }}" :model="$model"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="comment" title="{{ __('Comment') }}" :model="$model"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <a href="{{ url()->previous() }}" class="cancel-btn btn btn-light mr-1">{{ __('Cancel') }}</a>
                <button type="submit" class="btn waves-effect waves-light">{{ isset($model) ? __('Update') : __('Add Salary Review') }}</button>
            </div>
        </div>
    </div>
</form>
