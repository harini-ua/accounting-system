<form id="clients" method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">
    @if(isset($client)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <div class="row">
                <h4 class="card-title">{{ __('Main Info') }}</h4>
                @php($client = $client ?? null)
                <x-input name="name" title="{{ __('Client Name') }}" :model="$client"></x-input>
                <x-input name="company_name" title="{{ __('Company Name') }}" :model="$client"></x-input>
                <x-input name="email" title="{{ __('Client Email') }}" :model="$client" type="email"></x-input>
                <x-input name="phone" title="{{ __('Client Phone') }}" :model="$client"></x-input>
            </div>
        </div>
        <div class="col s12 m6">
            <h4 class="card-title">{{ __('Billing address') }}</h4>
            @php($address = $client->billingAddress ?? null)
            <x-input name="country" title="{{ __('Country') }}" :model="$address"></x-input>
            <x-input name="address" title="{{ __('Address') }}" :model="$address"></x-input>
            <x-input name="city" title="{{ __('City') }}" :model="$address"></x-input>
            <x-input name="state" title="{{ __('State') }}" :model="$address"></x-input>
            <x-input name="postal_code" title="{{ __('Zip Code') }}" :model="$address"></x-input>
        </div>
    </div>
    <div class="divider mt-2 mb-2"></div>
    <div class="row">
        <div class="col s12 m6">
            <h4 class="card-title">{{ __('Bank Details') }}</h4>
            @php($bank = $client->bank ?? null)
            <x-input name="bank_name" title="{{ __('Bank') }}" :model="$bank" field="name"></x-input>
            <x-input name="bank_address" title="{{ __('Bank Address') }}" :model="$bank" field="address"></x-input>
            <x-input name="account" title="{{ __('Account #') }}" :model="$bank"></x-input>
            <x-input name="iban" title="{{ __('IBAN') }}" :model="$bank"></x-input>
            <x-input name="swift" title="{{ __('SWIFT CODE') }}" :model="$bank"></x-input>
        </div>
    </div>
    <div class="row">
        <div class="col s12 display-flex justify-content-end mt-3">
            <a href="{{ previousOr('clients.index') }}" class="btn cancel-btn mr-1">{{ __('Cancel') }}</a>
            <button type="submit" class="btn waves-effect waves-light">{{ isset($client) ? __('Update') : __('Save') }}</button>
        </div>
    </div>
</form>
