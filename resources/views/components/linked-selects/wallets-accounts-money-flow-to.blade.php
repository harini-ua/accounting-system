<div class="col s12 input-field custom-select-wrapper">
    <input id="{{ $firstName }}-input"
           class="select-trigger"
           @if($model) value="{{ $model->accountTo->wallet->name }}" @endif
           type="text"
           readonly
    >
    <label for="{{ $firstName }}-input">{{ $firstTitle }}</label>
    <select id="{{ $firstName }}"
            name="{{ $firstName }}"
            data-placeholder="{{ __("- Select $firstTitle -") }}"
            class="select2 browser-default linked form-select"
            data-url="{{ $url }}"
            data-binded-select="{{$secondName}}"
    >
        @if(count($options))
            <option class="first_default">{{ __("- Select $firstTitle -") }}</option>
            @if($model)
                @foreach ($options as $wallet)
                    <option {{ $model->accountTo->wallet_id == $wallet->id ? 'selected' : '' }}
                            value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                @endforeach
            @else
                @foreach ($options as $wallet)
                    <option {{ old($firstName) == $wallet->id ? 'selected' : '' }}
                            value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                @endforeach
            @endif
        @endif
    </select>
</div>
<div class="col s12 input-field custom-select-wrapper">
    <input id="{{$secondName}}-input"
           class="select-trigger"
           @if($model) value="{{ $model->accountTo->accountType->name }}" @endif
           type="text"
           readonly
    >
    <label for="{{$secondName}}-input">{{ $secondTitle }}</label>
    <select id="{{ $secondName }}"
            name="{{ $secondName }}"
            data-placeholder="{{ __("- Select $secondTitle -") }}"
            class="select2 browser-default form-select"
            data-linked="{{ $firstName }}"
    >
        @if($model)
            @php $accounts = $options->find($model->accountTo->wallet_id)->accounts; @endphp
            @if(count($accounts))
                <option class="first_default">{{ __("- Select $secondTitle -") }}</option>
                @foreach ($accounts as $account)
                    <option {{ $model->account_to_id == $account->id ? 'selected' : '' }}
                            value="{{ $account->id }}">{{ $account->accountType->name }}</option>
                @endforeach
            @endif
        @else
            @php($wallet = old($firstName) ? $options->find(old($firstName)) : $options->first())
            <option class="first_default">{{ __('- Select '.$secondTitle.' -') }}</option>
            @if($wallet)
                @foreach ($wallet->accounts as $account)
                    <option {{ old($secondName) == $account->id ? 'selected' : '' }}
                            value="{{ $account->id }}">{{ $account->accountType->name }}</option>
                @endforeach
            @endif
        @endif
    </select>
</div>