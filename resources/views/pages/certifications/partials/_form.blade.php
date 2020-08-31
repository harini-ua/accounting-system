<!-- form start -->
<form class="{{isset($certification) ? '' : 'handle-submit-form'}}" id="certification" method="POST"
      action="{{ isset($certification) ? route('certifications.update', $certification) : route('certifications.store') }}"
      data-created-item="certification"  >
    @if(isset($certification)) @method('PUT') @endif
    @csrf
    @php($model = $certification ?? null)
    <div class="row">
        <div class="col s12 m6">
            <x-select name="person_id" :options="$people" :model="$model" firstTitle="Person" :search="true"></x-select>
        </div>
        <div class="col s12 m6">
            <x-input name="name" title="{{ __('Name') }}" :model="$model" field="name"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="subject" title="{{ __('Subject') }}" :model="$model" field="subject"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="cost" title="{{ __('Cost') }}" :model="$model" field="cost"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="availability" title="{{ __('Availability') }}" :model="$model"
                     field="availability"></x-input>
        </div>
        <div class="col s12 m6">
            <x-input name="sum_award" title="{{ __('Sum Award') }}" :model="$model" field="sum_award"></x-input>
        </div>
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <a href="{{ url()->previous() }}" class="chanel-btn btn btn-light {{ isset($certification) ? __('') : __('slide-up-btn') }} mr-1">{{ __('Cancel') }}</a>
                <button type="submit" class="btn waves-effect waves-light">{{ isset($certification) ? __('Update') : __('Add Certification') }}</button>
            </div>
            {{--<div class="pl-0 pr-0 right-align">--}}
                {{--<button class="btn-small waves-effect waves-light submit" type="submit">--}}
                {{--<span>{{ isset($certification) ? __('Update') : __('Add Certification') }}</span>--}}
                {{--</button>--}}
            {{--</div>--}}
        </div>
    </div>
</form>
<!-- form end -->
