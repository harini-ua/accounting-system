<div class="checkbox-input">
    <div class="">
        {{ $checkbox }}
    </div>
    <div class="row mt-10{{ $isCheckboxChecked() ? '' : ' hide' }}" data-checkbox="{{ $checkboxName }}">
        {{ $input }}
    </div>
</div>
