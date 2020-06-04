<h4 class="card-title">{{ __('Main Info') }}</h4>
<form id="clients" method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">
    @if(isset($client)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="input-field col s12">
            <input name="name" value="{{ $client->name ?? null }}" placeholder="{{ __('Input Client Name') }}" id="name" type="text">
            <label for="name" class="active">{{ __('Client Name') }}</label>
            @error('name')
            <small class="errorTxt2"><div id="name-error" class="error">{{ $message }}</div></small>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input name="company_name" value="{{ $client->company_name ?? null }}" placeholder="{{ __('Input Company Name') }}" id="company_name" type="text">
            <label for="company_name" class="active">{{ __('Company Name') }}</label>
            @error('company_name')
            <small class="errorTxt2"><div id="company_name-error" class="error">{{ $message }}</div></small>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input name="email" value="{{ $client->email ?? null }}" placeholder="{{ __('Input Client Email') }}" id="email" type="email">
            <label for="email" class="active">{{ __('Client Email') }}</label>
            @error('email')
            <small class="errorTxt2"><div id="email-error" class="error">{{ $message }}</div></small>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input name="phone" value="{{ $client->phone ?? null }}" placeholder="{{ __('Input Company Phone') }}" id="phone" type="text">
            <label for="phone" class="active">{{ __('Client Phone') }}</label>
            @error('phone')
            <small class="errorTxt2"><div id="phone-error" class="error">{{ $message }}</div></small>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col s12 display-flex justify-content-end mt-3">
            <button type="submit" class="btn indigo">{{ isset($client) ? __('Update') : __('Save') }}</button>
            <a href="{{ url()->previous() }}" class="btn btn-light">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>
