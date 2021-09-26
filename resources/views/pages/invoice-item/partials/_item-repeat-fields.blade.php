<div class="invoice-item-repeater">
    <div data-repeater-list="items">
    @php $count = $items ? $items->count() : 1 @endphp
    @for($i = 0; $i < $count; $i++)
        <div class="mb-2 invoice-item-wrapper" data-repeater-item>
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
                        <input type="text" name="items[{{ $i }}][title]" value="{{ old("items.$i.title") ?? ((!empty($items) && $items[$i]->title) ? $items[$i]->title :  null) }}" class="item-title">
                        <label for="title">{{ __('Item Title') }}</label>
                        @error('items.'.$i.'.title')<small class="errorTxt1"><div id="title-error" class="error">{{ $message }}</div></small>@enderror
                    </div>
                    <div class="col m3 s12 input-field">
                        <select name="items[{{ $i }}][type]" class="select2-icons invoice-item-select browser-default item-type">
                            @php( $item_type = old("items.$i.type") ?? (!empty($items) && $items[$i]->type) ?? null )
                            @foreach(\App\Enums\InvoiceItemType::asSelectArray() as $type => $value)
                                <option value="{{ $type }}" {{ $type === $item_type ? 'selected' : '' }}
                                        data-icon="{{ \App\Enums\InvoiceItemType::getIcon($type) }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('items.'.$i.'.type')<small class="errorTxt1"><div id="title-error" class="error">{{ $message }}</div></small>@enderror
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" name="items[{{ $i }}][qty]"
                               value="{{ old("items.$i.qty") ?? ((!empty($items) && $items[$i]->qty) ? $items[$i]->qty : null) }}"
                               class="item-qty" placeholder="0">
                        @error('items.'.$i.'.qty')<small class="errorTxt1"><div id="title-error" class="error">{{ $message }}</div></small>@enderror
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" name="items[{{ $i }}][rate]"
                               value="{{ old("items.$i.rate") ?? ((!empty($items) && $items[$i]->rate) ? $items[$i]->rate : null) }}"
                               class="item-rate" placeholder="0.00">
                        @error('items.'.$i.'.rate')<small class="errorTxt1"><div id="title-error" class="error">{{ $message }}</div></small>@enderror
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" name="items[{{ $i }}][sum]"
                               value="{{ \App\Services\Formatter::currency(old("items.$i.sum") ?? (!empty($items) && $items[$i]->sum) ? $items[$i]->sum : null) }}"
                               class="item-sum" placeholder="0.00" disabled>
                        <input type="hidden" name="items[{{ $i }}][raw]"
                               value="{{ old("items.$i.sum") ?? (!empty($items) && $items[$i]->sum) ? $items[$i]->sum : null }}"
                               class="item-raw">
                        @error('items.'.$i.'.sum')<small class="errorTxt1"><div id="title-error" class="error">{{ $message }}</div></small>@enderror
                    </div>
                    <div class="col m12 s12 input-field">
                        <textarea name="items[{{ $i }}][description]" class="item-description materialize-textarea">
{{  (!empty($items) && $items[$i]->description) ? $items[$i]->description : null }}</textarea>
                        <label for="description">{{ __('Item Description') }}</label>
                        @error('items.'.$i.'.description')<small class="errorTxt1"><div id="title-error" class="error">{{ $message }}</div></small>@enderror
                    </div>
                </div>
                <div class="invoice-icon display-flex justify-content-center  padding-2 align-items-center">
                    <span data-repeater-delete class="delete-row-btn indigo-text">
                        <i class="material-icons">delete</i>
                    </span>
                </div>
            </div>
        </div>
    @endfor
    </div>
    <div class="input-field">
        <button class="btn invoice-repeat-btn" data-repeater-create type="button">
            <i class="material-icons left">add</i>
            <span>{{ __('Add Item') }}</span>
        </button>
    </div>
</div>
