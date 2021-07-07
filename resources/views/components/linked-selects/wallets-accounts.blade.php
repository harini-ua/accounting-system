<div class="col s12 input-field custom-select-wrapper">
    <input id="{{ $firstName }}-input"
           class="select-trigger"
           @if($model) value="{{ $model->account->wallet->name }}" @endif
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
                    <option {{ $model->account->wallet_id == $wallet->id ? 'selected' : '' }}
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
    <span class="error-span"></span>
</div>
<div class="col s12 input-field custom-select-wrapper">
    <input id="{{ $secondName }}-input"
           class="select-trigger"
           @if($model) value="{{ $model->account->accountType->name }}"
           @endif type="text"
           readonly >
    <label for="{{ $secondName }}-input">{{ $secondTitle }}</label>
    <select id="{{ $secondName }}"
            name="{{ $secondName }}"
            data-placeholder="{{ __("- Select $secondTitle -") }}"
            class="select2 browser-default form-select"
            data-linked="{{ $firstName }}" >

        @if($model)
            @php $accounts = $options->find($model->account->wallet_id)->accounts; @endphp
            @if(count($accounts))
                <option class="first_default">{{ __("- Select $secondTitle -") }}</option>
                @foreach ($options->find($model->account->wallet_id)->accounts as $account)
                    @if($account->status == 1)
                    <option data-status="{{$account->status}}" {{ $model->account_id == $account->id ? 'selected' : '' }}
                            value="{{ $account->id }}">{{ $account->accountType->name }}</option>
                    @endif
                @endforeach
            @endif
        @else
            @php($wallet = old($firstName) ? $options->find(old($firstName)) : $options->first())
            <option class="first_default">{{ __("- Select $secondTitle -") }}</option>
            @if($wallet)
                @foreach ($wallet->accounts as $account)
                    @if($account->status == 1)
                    <option data-statuss="{{$account->status}}" {{ old($secondName) == $account->id ? 'selected' : '' }}
                            value="{{ $account->id }}">{{ $account->accountType->name }}</option>
                    @endif
                @endforeach
            @endif
        @endif
    </select>
    @error('account_id')
    <small class="errorTxt1">
        <div id="account_id-error" class="error">{{ $message }}</div>
    </small>
    @enderror
    <span class="error-span"></span>
</div>
