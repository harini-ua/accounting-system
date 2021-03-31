<div class="col s12 input-field custom-select-wrapper">
    <input id="{{$name}}-input" class="custom-select-input" type="text" readonly="true" value="{{ $selectedOptionName() }}">
    <label class="select-label" for="{{ $name }}-input">{{ $title }}</label>
    <select class="custom-select @if($search) select2 browser-default @endif" name="{{ $name }}" id="{{$name}}" {{ $disabled() }}>
        @if($isDefaultOption())
            <option class="first_default" value="">{{ $defaultOptionName }}</option>
        @endif
        @if($model)
            @foreach ($options as $option)
                <option {{ $selected($option) }} value="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        @else
            @foreach ($options as $option)
                <option {{ old($name) === $option->id ? 'selected' : '' }} {{ $selected($option) }} value="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        @endif
    </select>
    @if($title)
    <span class="error-span"></span>
    @endif
    @error($name)<span class="errorTxt1"><div id="{{$name}}-error" class="error">{{ $message }}</div></span>@enderror
</div>
