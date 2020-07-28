<div class="invoice-item-repeater">
    @foreach($items as $item)
        @include('pages.invoice-item.partials._item-form-fields', [ 'item' => $item ])
    @endforeach
    <div class="input-field">
        <button class="btn invoice-repeat-btn" data-repeater-create type="button">
            <i class="material-icons left">add</i>
            <span>{{ __('Add Item') }}</span>
        </button>
    </div>
</div>
