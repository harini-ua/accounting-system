@php($model = $certification ?? null)
<form id="certification" class="{{isset($model) ? '' : 'handle-submit-form'}}" method="POST"
      action="{{ isset($model) ? route('certifications.update', $model) : route('certifications.store') }}"
      data-created-item="certification">
    @if(isset($model)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-select name="person_id" :options="$people" title="{{ __('Person') }}" :model="$model" firstTitle="Person" :search="true"></x-select>
        </div>
        <div class="col s12 m6">
            <x-input name="name" title="{{ __('Name') }}" :model="$model" field="name"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-input name="subject" title="{{ __('Subject') }}" :model="$model" field="subject"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="cost" title="{{ __('Cost') }}" :model="$model" field="cost"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-input name="availability" title="{{ __('Availability') }}" :model="$model"
                     field="availability"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="sum_award" title="{{ __('Sum Award') }}" :model="$model" field="sum_award"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <a href="{{ url()->previous() }}" class="cancel-btn btn btn-light {{ isset($model) ? __('') : __('slide-up-btn') }} mr-1">{{ __('Cancel') }}</a>
                <button type="submit" class="btn waves-effect waves-light">{{ isset($model) ? __('Update') : __('Add Certification') }}</button>
            </div>
        </div>
    </div>
</form>
