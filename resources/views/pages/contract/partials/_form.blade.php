@php($model = $contract ?? null)
<form id="contracts" method="POST"
      class="{{ isset($model) ? '' : 'handle-submit-form with-clear-left' }}"
      action="{{ isset($model) ? route('contracts.update', $model) : route('contracts.store') }}"
      data-created-item="contract"
>
    @if(isset($model)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-input name="name" title="{{ __('Contract Name') }}" :model="$model"></x-input>
        </div>
        <div class="col s12 m6">
            <x-select name="client_id" title="{{ __('Select Client') }}" :model="$model" :options="$clients"></x-select>
        </div>
        <div class="col s12 m6">
            <x-select name="sales_manager_id" title="{{ __('Sales Manager') }}" :model="$model" :options="$salesManagers"></x-select>
        </div>
        <div class="col s12 m6">
            <x-select name="status" title="{{ __('Status') }}" :model="$model" :options="$status"></x-select>
        </div>
        <div class="col s12 m6">
            <x-textarea name="comment" title="{{ __('Comment') }}" :model="$model"></x-textarea>
        </div>
        <div class="col s12 display-flex justify-content-end mt-3">
            <a href="{{ previousOr('contracts.index') }}" class="cancel-btn btn btn-light {{ isset($contract) ? __('') : __('slide-up-btn') }} mr-1">{{ __('Cancel') }}</a>
            <button type="submit" class="btn ">{{ isset($contract) ? __('Update') : __('Save') }}</button>
        </div>
    </div>
</form>
