<div class="col s12 input-field">
    <input name="{{ $name }}" type="text" class="datepicker" value="{{ date('d-m-Y') }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <span class="error-span"></span>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
