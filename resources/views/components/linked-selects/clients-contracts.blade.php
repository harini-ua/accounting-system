<div class="s12 input-field">
    <select id="{{ $firstName }}" name="{{ $firstName }}" data-placeholder="{{ __('- Select '.$firstTitle.' -') }}" class="select2 browser-default linked" data-url="{{ $url }}">
        @if(count($options))
            <option class="first_default">{{ __('- Select '.$firstTitle.' -') }}</option>
            @if($model)
                @foreach ($options as $client)
                <option {{ $model->contract->client_id == $client->id ? 'selected' : '' }}
                        value="{{ $client->id }}">
                    {{ $client->name }}
                </option>
                @endforeach
            @else
                @foreach ($options as $client)
                <option {{ old($firstName) == $client->id ? 'selected' : '' }}
                        value="{{ $client->id }}">
                    {{ $client->name }}
                </option>
                @endforeach
            @endif
        @endif
    </select>
</div>

<div class="s12 input-field">
    <select id="{{ $secondName }}" name="{{ $secondName }}" data-placeholder="{{ __('- Select '.$secondTitle.' -') }}" class="select2 browser-default" data-linked="{{ $firstName }}">
        @if($model)
            @php $contracts = $options->find($model->contract->client_id)->contracts; @endphp
            @if(count($contracts))
                <option class="first_default">{{ __('- Select '.$secondTitle.' -') }}</option>
                @foreach ($contracts as $contract)
                <option {{ $model->contract_id == $contract->id ? 'selected' : '' }}
                        value="{{ $contract->id }}">
                    {{ $contract->name }}
                </option>
                @endforeach
            @endif
        @endif
    </select>
    @error('contract_id')<small class="errorTxt1"><div id="contract_id-error" class="error">{{ $message }}</div></small>@enderror
</div>
