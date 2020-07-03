<div class="col s12 input-field">
    <select id="{{ $firstName }}" name="{{ $firstName }}" class="linked" data-url="{{ $url }}">
        @if($model)
            @foreach ($options as $wallet)
                <option {{ $model->account->wallet_id == $wallet->id ? 'selected' : '' }}
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
    </select>
    <label for="{{ $firstName }}">{{ $firstTitle }}</label>
</div>
<div class="col s12 input-field">
    <select id="{{ $secondName }}" name="{{ $secondName }}" data-linked="{{ $firstName }}">
        @if($model)
            @foreach ($options->find($model->account->wallet_id)->accounts as $account)
                <option {{ $model->account_id == $account->id ? 'selected' : '' }}
                        value="{{ $account->id }}">
                    {{ $account->accountType->name }}
                </option>
            @endforeach
        @else
            @php($wallet = old($firstName) ? $options->find(old($firstName)) : $options->first())
            @foreach ($wallet->accounts as $account)
                <option {{ old($secondName) == $account->id ? 'selected' : '' }}
                        value="{{ $account->id }}">
                    {{ $account->accountType->name }}
                </option>
            @endforeach
        @endif
    </select>
    <label for="{{ $secondName }}">{{ $secondTitle }}</label>
</div>

@push('components-scripts')
    <script src="{{ asset('js/scripts/linked-selects.js') }}"></script>
@endpush
