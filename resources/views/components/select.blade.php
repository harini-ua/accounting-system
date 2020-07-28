<div class="col s12 input-field">
    <select name="{{ $name }}" {{ $disabled() }}>
        @if($model)
            @foreach ($options as $option)
                <option {{ $selected($option) }}
                        value="{{ $option->id }}">
                    {{ $option->name }}
                </option>
            @endforeach
        @else
            @foreach ($options as $option)
                <option {{ old($name) == $option->id ? 'selected' : '' }}
                        value="{{ $option->id }}">
                    {{ $option->name }}
                </option>
            @endforeach
        @endif
    </select>
    <label for="{{ $name }}">{{ $title }}</label>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
