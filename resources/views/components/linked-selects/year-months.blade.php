<div class="col s12 m6">
    <div class="col s12 input-field">
        <select id="{{ $firstName }}" name="{{ $firstName }}" data-placeholder="{{ __('- Select '.$firstTitle.' -') }}"
                class="select2 browser-default linked" data-url="{{ $url }}">
            @if(count($options))
                <option class="first_default">{{ __('- Select '.$firstTitle.' -') }}</option>
                @if($model)
                    @foreach ($options as $calendarYear)
                        <option {{ $model->calendarMonth->calendar_year_id == $calendarYear->id ? 'selected' : '' }}
                                value="{{ $calendarYear->id }}">
                            {{ $calendarYear->name }}
                        </option>
                    @endforeach
                @else
                    @foreach ($options as $calendarYear)
                        <option {{ old($firstName) == $calendarYear->id ? 'selected' : '' }}
                                value="{{ $calendarYear->id }}">
                            {{ $calendarYear->name }}
                        </option>
                    @endforeach
                @endif
            @endif
        </select>
        <span class="error-span"></span>
    </div>
</div>

<div class="col s12 m6">
    <div class="col s12 input-field">
        <select id="{{ $secondName }}" name="{{ $secondName }}"
                data-placeholder="{{ __('- Select '.$secondTitle.' -') }}" class="select2 browser-default"
                data-linked="{{ $firstName }}">
            @if($model)
                @php $calendarMonths = $options->find($model->calendarMonth->calendar_year_id)->calendarMonths; @endphp
                @if(count($calendarMonths))
                    <option class="first_default">{{ __('- Select '.$secondTitle.' -') }}</option>
                    @foreach ($calendarMonths as $calendarMonth)
                        <option {{ $model->calendar_month_id == $calendarMonth->id ? 'selected' : '' }}
                                value="{{ $calendarMonth->id }}">
                            {{ $calendarMonth->name }}
                        </option>
                    @endforeach
                @endif
            @endif
        </select>
        @error('contract_id')<small class="errorTxt1">
            <div id="contract_id-error" class="error">{{ $message }}</div>
        </small>@enderror
        <span class="error-span"></span>
    </div>
</div>
