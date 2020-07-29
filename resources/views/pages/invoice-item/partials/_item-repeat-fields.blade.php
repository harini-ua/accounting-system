<div class="invoice-item-repeater">
    @foreach($items as $item)
    <div data-repeater-list="group-a">
        <div class="mb-2" data-repeater-item>
            <!-- invoice Titles -->
            <div class="row mb-1">
                <div class="col s3 m3">
                    <h6 class="m-0">{{ __('Item') }}</h6>
                </div>
                <div class="col s3 m3">
                    <h6 class="m-0">{{ __('Type') }}</h6>
                </div>
                <div class="col s2 m2">
                    <h6 class="m-0">{{ __('Qty') }}</h6>
                </div>
                <div class="col s2 m2">
                    <h6 class="m-0">{{ __('Rate') }}</h6>
                </div>
                <div class="col s2 m2">
                    <h6 class="m-0">{{ __('Sum') }}</h6>
                </div>
            </div>
            <div class="invoice-item display-flex mb-1">
                <div class="invoice-item-filed row pt-1">
                    <div class="col s12 m3 input-field">
                        <input type="text" id="title">
                        <label for="title">{{ __('Item Title') }}</label>
                    </div>
                    <div class="col m3 s12 input-field">
                        <select id="type" class="select2-icons invoice-item-select browser-default">
                            @foreach(\App\Enums\InvoiceItemType::toSelectArray() as $key => $type)
                                <option value="{{ $key }}" data-icon="{{ \App\Enums\InvoiceItemType::getIcon($key) }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" id="qty" placeholder="0">
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" id="rate" placeholder="$ 0.00">
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" id="sum" placeholder="$ 0.00" disabled>
                    </div>
                    <div class="col m12 s12 input-field">
                        <textarea type="text" id="description" class="materialize-textarea"></textarea>
                        <label for="description">{{ __('Item Description') }}</label>
                    </div>
                </div>
                <div class="invoice-icon display-flex flex-column justify-content-between">
              <span data-repeater-delete class="delete-row-btn">
                <i class="material-icons">clear</i>
              </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="input-field">
        <button class="btn invoice-repeat-btn" data-repeater-create type="button">
            <i class="material-icons left">add</i>
            <span>{{ __('Add Item') }}</span>
        </button>
    </div>
</div>
