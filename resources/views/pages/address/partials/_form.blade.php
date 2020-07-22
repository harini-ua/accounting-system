<form id="clients" method="POST" action="{{ isset($client) ? route('address.update', $client) : route('address.store') }}">
    @if(isset($address)) @method('PUT') @endif
    @csrf
    <h4 class="card-title">{{ __('Address') }}</h4>
    <div class="row">
        <x-input name="country" title="{{ __('Country') }}" :model="$address"></x-input>
        <x-input name="address" title="{{ __('Address') }}" :model="$address"></x-input>
        <x-input name="city" title="{{ __('City') }}" :model="$address"></x-input>
        <x-input name="state" title="{{ __('State') }}" :model="$address"></x-input>
        <x-input name="postal_code" title="{{ __('Zip Code') }}" :model="$address"></x-input>
    </div>
</form>