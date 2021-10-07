<div class="col s12 input-field">
    <input
        id="{{$name}}-input"
        readonly="true"
        name="{{ $name }}"
        type="text"
        class="datepicker"
        value="{{ date('d-m-Y') }}"
        @if($min)min="{{ $min }}"@endif
        @if($max)min="{{ $max }}"@endif
    />
    <label for="{{ $name }}-input">{{ $title }}</label>
    @if($title)
    <span class="error-span"></span>
    @endif
    @error($name)
    <span class="errorTxt1"><div id="{{$name}}-error" class="error">{{ $message }}</div></span>
    @enderror
</div>
