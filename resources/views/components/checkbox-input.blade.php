<div class="checkbox-input">
    <div>
        {{ $checkbox }}
    </div>
    <div class="{{ $isCheckboxChecked() ? '' : ' hide' }}" data-checkbox="{{ $checkboxName }}">
        {{ $input }}
    </div>
</div>

