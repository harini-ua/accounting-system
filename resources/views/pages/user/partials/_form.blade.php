@php($model = $user ?? null)
<form id="account" class="{{isset($model) ? '' : 'handle-submit-form'}}" method="POST"
      action="{{ isset($model) ? route('users.update', $model) : route('users.store') }}"
      data-created-item="user" >
    @if(isset($model)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-input name="name" title="{{ __('Name') }}" :model="$model"></x-input>
        </div>
        <div class="col s12 m6">
            <x-select name="position_id" title="{{ __('Position') }}" :model="$model" :options="$positions"></x-select>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <x-input name="email" title="{{ __('E-mail') }}" :model="$model"></x-input>
        </div>
        @if(!isset($model))
        <div class="col s12 m6">
            <div class="col s12 input-field">
                <input id="password" name="password" type="password" class="validate" value="{{ old('password') }}"
                       data-error=".errorTxt1">
                <label for="password">{{ __('Password') }}</label>
                @error('password')
                <small class="errorTxt3">{{ $message }}</small>
                @enderror
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <a href="{{ url()->previous() }}" class=" btn cancel-btn {{ isset($model) ? __('') : __('slide-up-btn') }} mr-1">{{ __('Cancel') }}</a>
                <button type="submit" class="btn waves-effect waves-light">{{ isset($model) ? __('Update') : __('Add User') }}</button>
            </div>
        </div>
    </div>
</form>
