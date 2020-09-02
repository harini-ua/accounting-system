@if($type !== 'hidden')
<div class="col s12 input-field">
@endif
    <input name="{{ $name }}" type="{{ $type }}" id="{{ $id }}" value="{{ $value() }}">
@if($type !== 'hidden')
    <label for="{{ $id }}">{{ $title }}</label>
    <span class="error-span"></span>
    @error($name)<span class="errorTxt1"><div id="{{$name}}-error" class="error">{{ $message }}</div></span>@enderror
</div>
@endif