<div class="col s12 input-field custom-select-wrapper">
    <input class="select-trigger" id="{{ $firstName }}-input" type="text" readonly>
    <label for="{{ $firstName }}-input">{{ $firstTitle  }}</label>
    <select id="{{ $firstName }}" name="{{ $firstName }}" data-placeholder="{{ __('- Select '.$firstTitle.' -') }}"
            class="select2 form-select browser-default linked" data-url="{{ $url }}"
            data-binded-select="{{$secondName}}">
        @if(count($options))
            <option class="first_default">{{ __('- Select '.$firstTitle.' -') }}</option>
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
    <input class="select-trigger" id="{{ $secondName }}-input" type="text" readonly>
    <label for="{{ $secondName }}-input">{{ $secondTitle  }}</label>
    <select id="{{ $secondName }}" name="{{ $secondName }}" data-placeholder="{{ __('- Select '.$secondTitle.' -') }}"
            class="select2 form-select browser-default" data-linked="{{ $firstName }}">
        <option class="first_default">{{ __('- Select '.$secondTitle.' -') }}</option>
        @if($model)
            @php $accounts = $options->find($model->account->wallet_id)->accounts; @endphp
            @if(count($accounts))
                @foreach ($options->find($model->account->wallet_id)->accounts as $account)
                    <option {{ $model->account_id == $account->id ? 'selected' : '' }}
                            value="{{ $account->id }}">{{ $account->accountType->name }}</option>
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
