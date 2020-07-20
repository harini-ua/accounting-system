<div class="col s12 input-field">
    <select id="{{ $firstName }}" name="{{ $firstName }}" class="linked" data-url="{{ $url }}">
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
    </select>
    <label for="{{ $firstName }}">{{ $firstTitle }}</label>
</div>
<div class="col s12 input-field">
    <select id="{{ $secondName }}" name="{{ $secondName }}" data-linked="{{ $firstName }}">
        @if($model)
            @foreach ($options->find($model->contract->client_id)->contracts as $contract)
                <option {{ $model->contract_id == $contract->id ? 'selected' : '' }}
                        value="{{ $contract->id }}">
                    {{ $contract->name }}
                </option>
            @endforeach
        @else
            @php($client = old($firstName) ? $options->find(old($firstName)) : $options->first())
            @foreach ($client->contracts as $contract)
                <option {{ old($secondName) == $contract->id ? 'selected' : '' }}
                        value="{{ $contract->id }}">
                    {{ $contract->name }}
                </option>
            @endforeach
        @endif
    </select>
    <label for="{{ $secondName }}">{{ $secondTitle }}</label>
</div>
