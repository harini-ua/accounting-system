<div class="col s12 input-field custom-select-wrapper">
    <input type="text" id="{{$firstName}}-input" class="select-trigger">
    <label for="{{$firstName}}-input">{{ $firstTitle }}</label>
    <select id="{{ $firstName }}" name="{{ $firstName }}" data-placeholder="{{ __('- Select '.$firstTitle.' -') }}"
            class="select2 browser-default linked form-select" data-url="{{ $url }}"
            data-binded-select="{{$secondName}}">
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
                            value="{{ $client->id }}"
                    >{{ $client->name }}
                    </option>
                @endforeach
            @endif
        @endif
    </select>
    <span class="error-span"></span>
</div>
<div class="col s12 input-field custom-select-wrapper">
    <input type="text" id="{{$secondName}}-input" class="select-trigger">
    <label for="{{$secondName}}-input">{{ $secondTitle }}</label>
    <select id="{{ $secondName }}" name="{{ $secondName }}"
            data-placeholder="{{ __('- Select '.$secondTitle.' -') }}" class="select2 browser-default form-select"
            data-linked="{{ $firstName }}">
            <option class="first_default">{{ __('- Select '.$secondTitle.' -') }}</option>
    @if($model)
            @php $contracts = $options->find($model->contract->client_id)->contracts; @endphp
            @if(count($contracts))
                @foreach ($contracts as $contract)
                    <option {{ $model->contract_id == $contract->id ? 'selected' : '' }} value="{{ $contract->id }}">{{ $contract->name }}</option>
                @endforeach
            @endif
        @endif
    </select>
    @error('contract_id')
    <small class="errorTxt1">
        <div id="contract_id-error" class="error">{{ $message }}</div>
    </small>
    @enderror
    <span class="error-span"></span>
</div>

