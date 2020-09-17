<div class="input-field col s12">
    <textarea name="{{ $name }}" class="materialize-textarea">{{ $value() }}</textarea>
    <label class="no-pointer-events" for="{{ $name }}">{{ $title }}</label>
    @error($name)
    @error($name)<span class="errorTxt1"><div id="{{$name}}-error" class="error">{{ $message }}</div></span>@enderror
    {{--<span class="helper-text">{{ $message }}</span>--}}
    @enderror
</div>
