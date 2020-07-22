<h4 class="card-title">{{ __('Main Info') }}</h4>
<form id="clients" method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">
    @if(isset($client)) @method('PUT') @endif
    @csrf
    <div class="row">
        @php($client = $client ?? null)
        <x-input name="name" title="{{ __('Client Name') }}" :model="$client"></x-input>
        <x-input name="company_name" title="{{ __('Company Name') }}" :model="$client"></x-input>
        <x-input name="email" title="{{ __('Client Email') }}" :model="$client" type="email"></x-input>
        <x-input name="phone" title="{{ __('Client Phone') }}" :model="$client"></x-input>
    </div>
    <h4 class="card-title">{{ __('Billing address') }}</h4>
    <div class="row">
        @php($address = $client->billingAddress ?? null)
        <x-input name="country" title="Country" :model="$address"></x-input>
        <x-input name="address" title="Address" :model="$address"></x-input>
        <x-input name="city" title="City" :model="$address"></x-input>
        <x-input name="state" title="State" :model="$address"></x-input>
        <x-input name="postal_code" title="Zip code" :model="$address"></x-input>
    </div>
    <div class="row">
        <div class="col s12 display-flex justify-content-end mt-3">
            <button type="submit" class="btn indigo mr-3">{{ isset($client) ? __('Update') : __('Save') }}</button>
            <a href="{{ url()->previous() }}" class="btn btn-light">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>
