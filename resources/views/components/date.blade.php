<div class="col s12 input-field">
    <input name="{{ $name }}" type="text" class="datepicker" value="{{ $value() }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <span class="error-span"></span>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
