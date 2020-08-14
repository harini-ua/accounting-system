<!-- form start -->
<form id="certification" method="POST" action="{{ isset($certification) ? route('certifications.update', $certification) : route('certifications.store') }}">
    @if(isset($certification)) @method('PUT') @endif
    @csrf
    @php($model = $certification ?? null)
    <div class="row">
        <x-select name="person_id" :options="$people" :model="$model" firstTitle="Person" :search="true"></x-select>
    </div>
    <div class="row">
        <x-input name="name" title="{{ __('Name') }}" :model="$model" field="name"></x-input>
    </div>
    <div class="row">
        <x-input name="subject" title="{{ __('Subject') }}" :model="$model" field="subject"></x-input>
    </div>
    <div class="row">
        <x-input name="cost" title="{{ __('Cost') }}" :model="$model" field="cost"></x-input>
    </div>
    <div class="row">
        <x-input name="availability" title="{{ __('Availability') }}" :model="$model" field="availability"></x-input>
    </div>
    <div class="row">
        <x-input name="sum_award" title="{{ __('Sum Award') }}" :model="$model" field="sum_award"></x-input>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="pl-0 pr-0 right-align">
                <button class="btn-small waves-effect waves-light submit" type="submit">
                    <span>{{ isset($certification) ? __('Update') : __('Add Certification') }}</span>
                </button>
            </div>
        </div>
    </div>
</form>
<!-- form end -->