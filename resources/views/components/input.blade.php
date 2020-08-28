<div class="col s12 input-field">
    <input name="{{ $name }}" type="{{ $type }}" id="{{ $id }}" value="{{ $value() }}">
    <label for="{{ $id }}">{{ $title }}</label>
    <span class="error-span"></span>
    @error($name)<span class="errorTxt1"><div id="{{$name}}-error" class="error">{{ $message }}</div></span>@enderror
</div>
