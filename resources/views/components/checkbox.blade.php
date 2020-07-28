<div class="col s12 input-field">
    <label>
        <input id="{{ $name }}" name="{{ $name }}" type="checkbox" value="1" {{ $checked }} />
        <span>{{ $title }}</span>
    </label>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
