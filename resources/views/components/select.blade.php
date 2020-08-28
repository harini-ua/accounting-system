<div class="col s12 input-field">
    <select @if($search)class="select2 browser-default"@endif name="{{ $name }}" id="{{$name}}" {{ $disabled() }}>
        @if($isDefaultOption())
            <option class="first_default" value="">{{ $defaultOptionName }}</option>
        @endif
        @if($model)
            @foreach ($options as $option)
                <option {{ $selected($option) }} value="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        @else
            @foreach ($options as $option)
                <option {{ old($name) == $option->id ? 'selected' : '' }}value="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        @endif
    </select>
    @if($title)
    <label for="{{ $name }}">{{ $title }}</label>
    <span class="error-span"></span>

    @endif
    @error($name)<span class="errorTxt1"><div id="{{$name}}-error" class="error">{{ $message }}</div></span>@enderror
</div>
