<div class="col s12 input-field">
    <select id="{{ $firstName }}" name="{{ $firstName }}" data-placeholder="{{ __('- Select '.$firstTitle.' -') }}" class="select2 browser-default linked" data-url="{{ $url }}">
        @if(count($options))
            <option class="first_default">{{ __('- Select '.$firstTitle.' -') }}</option>
            @if($model)
                @foreach ($options as $wallet)
                <option {{ $model->accountFrom->wallet_id == $wallet->id ? 'selected' : '' }}
                        value="{{ $wallet->id }}">
                    {{ $wallet->name }}
                </option>
                @endforeach
            @else
                @foreach ($options as $wallet)
                <option {{ old($firstName) == $wallet->id ? 'selected' : '' }}
                        value="{{ $wallet->id }}">
                    {{ $wallet->name }}
                </option>
                @endforeach
            @endif
        @endif
    </select>
</div>
<div class="col s12 input-field">
    <select id="{{ $secondName }}" name="{{ $secondName }}" data-placeholder="{{ __('- Select '.$secondTitle.' -') }}" class="select2 browser-default" data-linked="{{ $firstName }}">
        @if($model)
            @php $accounts = $options->find($model->accountFrom->wallet_id)->accounts; @endphp
            @if(count($accounts))
                <option class="first_default">{{ __('- Select '.$secondTitle.' -') }}</option>
                @foreach ($accounts as $account)
                <option {{ $model->account_from_id == $account->id ? 'selected' : '' }}
                        value="{{ $account->id }}">
                    {{ $account->accountType->name }}
                </option>
                @endforeach
            @endif
        @endif
    </select>
</div>
