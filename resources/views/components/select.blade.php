<div class="col s12 input-field">
    <select id="{{ $name }}" name="{{ $name }}" {{ $disabled() }}>
        @foreach ($options as $option)
            <option {{ $selected($option) }}
                    value="{{ $option->id }}">
                {{ $option->name }}
            </option>
        @endforeach
    </select>
    <label for="{{ $name }}">{{ $title }}</label>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
