<div class="input-field col s12">
    <i class="material-icons prefix">mode_edit</i>
    <textarea id="{{ $name }}" name="{{ $name }}" class="materialize-textarea">{{ $value() }}</textarea>
    <label for="{{ $name }}">{{ $title }}</label>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
