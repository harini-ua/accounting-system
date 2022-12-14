<form id="invoices" method="POST"
      action="{{ isset($invoice) ? route('invoices.update', $invoice) : route('invoices.store') }}">
    @if(isset($invoice)) @method('PUT') @endif
    @php $model = $invoice ?? null @endphp
    @csrf
    <div class="row changed-row-margin">
        <div class="col xl9 m8 s12">
            <div class="card">
                <div class="card-content px-36">
                    <div class="row mb-3">
                        <div class="hidden">
                            <input type="hidden" name="type" value="{{ \App\Enums\InvoiceType::DEFAULT }}">
                            <script>
                                const numberFormat = @json(array_values(config('general.number.format')));
                                const accountCurrency = @json($accountCurrency);
                            </script>
                        </div>
                        <div class="col xl4 m12 display-flex align-items-center">
                            <input type="text" value="{{ $invoice->number ?? null }}" placeholder="{{ __('INV-00000') }}" disabled>
                        </div>
                        <div class="col xl8 m12">
                            <div class="invoice-date-picker display-flex align-items-center">
                                <div class="display-flex align-items-center">
                                    <small>{{ __('Invoice Date') }}</small>
                                    <div class="display-flex ml-4 input-field">
                                        <div class="col s12 input-field">
                                        <input type="text" name="date"
                                               value="{{ old('date') ?? $invoice->date ?? \Carbon\Carbon::now()->format(config('invoices.date.format')) }}"
                                               class="datepicker mr-2 mb-1"
                                               placeholder="{{ __('Select Date') }}">
                                        @error('date')
                                        <span class="error-span"></span>
                                        <small class="errorTxt1">
                                            <div id="date-error" class="error">{{ $message }}</div>
                                        </small>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="display-flex align-items-center">
                                    <small>{{ __('Plan Income Date') }}</small>
                                    <div class="display-flex ml-4">
                                        <div class="col s12 input-field">
                                        <input type="text" name="plan_income_date"
                                               value="{{ old('plan_income_date') ?? $invoice->plan_income_date ?? null }}"
                                               class="datepicker mr-2 mb-1"
                                               placeholder="{{ __('Select Date') }}">
                                        @error('plan_income_date')
                                        <span class="error-span"></span>
                                        <small class="errorTxt1">
                                            <div id="plan_income_date-error" class="error">{{ $message }}</div>
                                        </small>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        @if($image)
                            <div class="col m6 s12 invoice-logo display-flex pt-1 push-m6">
                                <img src="{{ $image['src'] }}" alt="logo" height="{{ $image['height'] }}"
                                     width="{{ $image['width'] }}"/>
                            </div>
                        @endif
                        <div class="col m6 s12 pull-m6 p-0">
                            <div class="col s12">
                                <h4 class="indigo-text">Invoice</h4>
                            </div>
                            <x-input name="name" title="{{ __('Invoice Name') }}" :model="$model"></x-input>
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                    <div class="row mb-3">
                        <div class="col l6 s12 p-0 row">
                            <h6 class="col s12">{{ __('Client / Contract') }}</h6>
                            <x-linked-selects
                                firstName="client_id"
                                firstTitle="Client"
                                secondName="contract_id"
                                secondTitle="Contract"
                                dataUrl="/clients/[id]/contracts"
                                view="components.linked-selects.clients-contracts"
                                :options="$clients"
                                :model="$model"
                            />
                        </div>
                        <div class="col l6 s12  p-0 row">
                            <h6 class="col s12">{{ __('Wallet / Account') }}</h6>
                            <x-linked-selects
                                firstName="wallet_id"
                                firstTitle="Wallet"
                                secondName="account_id"
                                secondTitle="Account"
                                dataUrl="/wallets/[id]/accounts"
                                view="components.linked-selects.wallets-accounts"
                                :options="$wallets"
                                :model="$model"
                            />
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                    <div class="invoice-product-details mb-3">
                        @include('pages.invoice-item.partials._item-repeat-fields', ['items' => isset($invoice) ? $invoice->items : []])
                    </div>
                    <div class="invoice-subtotal">
                        <div class="row">
                            <div class="col m5 s12">
                                <x-input name="discount" title="{{ __('Discount') }}" :model="$model"></x-input>
                                <x-select name="sales_manager_id"
                                        title="{{ __('Sales Manager') }}"
                                        :options="$sales"
                                        :model="$model"
                                        firstTitle="{{ __('Sales Manager') }}"
                                ></x-select>
                            </div>
                            <div class="col xl4 m7 s12 offset-xl3">
                                <ul>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">{{ __('Subtotal') }}</span>
                                        <h6 class="invoice-subtotal-value currency">
                                            {!! \App\Services\Formatter::currency(isset($invoice) ? $invoice->items->sum('sum') : null, isset($invoice) ? $invoice->account->accountType->symbol : null, true) !!}
                                            <span
                                                class="hide raw">{{ isset($invoice) ? $invoice->items->sum('sum') : null }}</span>
                                        </h6>
                                    </li>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-discount-title">{{ __('Discount') }}</span>
                                        <h6 class="invoice-discount-value currency">
                                            - {!! \App\Services\Formatter::currency(isset($invoice) ? $invoice->discount : null, isset($invoice) ? $invoice->account->accountType->symbol : null, true) !!}</h6>
                                    </li>
                                    <li>
                                        <div class="divider mt-2 mb-2"></div>
                                    </li>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-total-title">{{ __('Invoice Total') }}</span>
                                        <h6 class="invoice-total-value currency">{!! \App\Services\Formatter::currency(isset($invoice) ? $invoice->items->sum('sum') - $invoice->discount : null, isset($invoice) ? $invoice->account->accountType->symbol : null, true) !!}</h6>
                                    </li>
                                    @if(isset($invoice))
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-paid-title">{{ __('Paid to date') }}</span>
                                            <h6 class="invoice-paid-value currency">
                                                - {!! \App\Services\Formatter::currency(isset($invoice) ? $invoice->payments->sum('fee') : null, isset($invoice) ? $invoice->account->accountType->symbol : null, true) !!}</h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-balance-title">{{ __('Balance (USD)') }}</span>
                                            <h6 class="invoice-balance-value currency">{!! \App\Services\Formatter::currency(isset($invoice) ? $invoice->payments->sum('fee') : null, isset($invoice) ? $invoice->account->accountType->symbol : null, true) !!}</h6>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col xl3 m4 s12">
            <div class="card invoice-action-wrapper mb-10">
                <div class="card-content">
                    <div class="input-field">
                        <h6>{{ __('Status') }}</h6>
                        <select name="status" class="select2 invoice-item-select browser-default">
                            @foreach(\App\Enums\InvoiceStatus::asSelectArray() as $value => $status)
                                <option
                                    value="{{ $value }}" {{ isset($invoice) && $invoice->status == $value ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <small class="errorTxt1">
                            <div id="status-error" class="error">{{ $message }}</div>
                        </small>
                        @enderror
                    </div>
                    <div class="invoice-action-btn">
                        <button
                            class="btn btn-block waves-effect waves-light display-flex align-items-center justify-content-center"
                            type="submit">
                            {{ isset($invoice) ? __('Update Invoice') : __('Save Invoice') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
