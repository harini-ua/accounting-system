<div class="col s12 input-field">
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value() }}">
    <label for="{{ $name }}">{{ $title }}</label>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
