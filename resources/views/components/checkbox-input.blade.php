<div class="checkbox-input">
    <div class="row">
        {{ $checkbox }}
    </div>
    <div class="row mt-10{{ $isCheckboxChecked() ? '' : ' hide' }}" data-checkbox="{{ $checkboxName }}">
        {{ $input }}
    </div>
</div>
