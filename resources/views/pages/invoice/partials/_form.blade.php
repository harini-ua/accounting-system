<form id="invoices" method="POST" action="{{ isset($invoice) ? route('invoices.update', $invoice) : route('invoices.store') }}">
    @if(isset($invoice)) @method('PUT') @endif
    @php $model = $invoice ?? null @endphp
    @csrf
    <div class="row">
        <!-- invoice view page -->
        <div class="col xl9 m8 s12">
            <div class="card">
                <div class="card-content px-36">
                    <!-- header section -->
                    <div class="row mb-3">
                        <div class="hidden">
                            <input type="hidden" name="type" value="{{ \App\Enums\InvoiceType::DEFAULT }}">
                        </div>
                        <div class="col xl4 m12 display-flex align-items-center">
                            <input type="text" value="{{ $invoice->number ?? null }}" placeholder="{{ __('INV-00000') }}" disabled>
                        </div>
                        <div class="col xl8 m12">
                            <div class="invoice-date-picker display-flex align-items-center">
                                <div class="display-flex align-items-center">
                                    <small>{{ __('Invoice Date') }}</small>
                                    <div class="display-flex ml-4">
                                        <input type="text" name="date"
                                               value="{{ isset($invoice) ? $invoice->date : (old('date')) ?? \Carbon\Carbon::now()->format(config('invoices.date.format')) }}"
                                               class="datepicker mr-2 mb-1"
                                               placeholder="{{ __('Select Date') }}">
                                        @error('date')<small class="errorTxt1"><div id="date-error" class="error">{{ $message }}</div></small>@enderror
                                    </div>
                                </div>
                                <div class="display-flex align-items-center">
                                    <small>{{ __('Plan Income Date') }}</small>
                                    <div class="display-flex ml-4">
                                        <input type="text" name="plan_income_date" value="{{ $invoice->plan_income_date ?? (old('plan_income_date')) ?? null }}" class="datepicker mb-1" placeholder="{{ __('Select Date') }}">
                                        @error('plan_income_date')<small class="errorTxt1"><div id="plan_income_date-error" class="error">{{ $message }}</div></small>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- logo and title -->
                    <div class="row mb-3">
                        @if($image)
                            <div class="col m6 s12 invoice-logo display-flex pt-1 push-m6">
                                <img src="{{ $image['src'] }}" alt="logo" height="{{ $image['height'] }}" width="{{ $image['width'] }}" />
                            </div>
                        @endif
                        <div class="col m6 s12 pull-m6">
                            <h4 class="indigo-text">Invoice</h4>
                            <div class="input-field">
                                <input name="name" value="{{ $invoice->name ?? (old('name')) ?? null }}" type="text">
                                <label for="name" data-error="wrong" data-success="right">{{ __('Invoice Name') }}</label>
                                @error('name')<small class="errorTxt1"><div id="name-error" class="error">{{ $message }}</div></small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                    <!-- invoice client and wallet -->
                    <div class="row mb-3">
                        <div class="col l6 s12">
                            <h6>{{ __('Client / Contract') }}</h6>
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
                        <div class="col l6 s12">
                            <h6>{{ __('Wallet / Account') }}</h6>
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
                    <!-- product details table-->
                    <div class="invoice-product-details mb-3">
                        @include('pages.invoice-item.partials._item-repeat-fields', ['items' => isset($invoice) ? $invoice->items : []])
                    </div>
                    <!-- invoice subtotal -->
                    <div class="invoice-subtotal">
                        <div class="row">
                            <div class="col m5 s12">
                                <div class="input-field">
                                    <input name="discount" type="text" value="{{ $invoice->discount ?? (old('discount')) ?? null }}" placeholder="{{ __('0.00') }}">
                                    <label for="discount">{{ __('Discount') }}</label>
                                </div>
                                <div class="input-field">
                                    <select name="sales_manager_id" class="select2 invoice-item-select browser-default">
                                        <option value="">{{ __('- Select Sales Manager -') }}</option>
                                        @php( $sales_manager_id = isset($invoice) && $invoice->sales_manager_id ?? (old('discount')) ?? null )
                                        @foreach($sales as $user)
                                            <option value="{{ $user->id }}" {{ isset($invoice) && $sales_manager_id == $user->id  ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sales_manager_id')<small class="errorTxt1"><div id="sales_manager_id-error" class="error">{{ $message }}</div></small>@enderror
                                </div>
                            </div>
                            <div class="col xl4 m7 s12 offset-xl3">
                                <ul>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">{{ __('Subtotal') }}</span>
                                        <h6 class="invoice-subtotal-value">$ {{ isset($invoice) ? $invoice->items->sum('sum') : '00.00' }}</h6>
                                    </li>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">{{ __('Discount') }}</span>
                                        <h6 class="invoice-subtotal-value">- $ {{ isset($invoice) ? $invoice->discount : '00.00' }}</h6>
                                    </li>
                                    <li>
                                        <div class="divider mt-2 mb-2"></div>
                                    </li>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">{{ __('Invoice Total') }}</span>
                                        <h6 class="invoice-subtotal-value">$ {{ isset($invoice) ? $invoice->items->sum('sum') - $invoice->discount : '00.00' }}</h6>
                                    </li>
                                    @if(isset($invoice))
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Paid to date') }}</span>
                                            <h6 class="invoice-subtotal-value">- $ {{ isset($invoice) ? $invoice->payments->sum('fee') : '00.00' }}</h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Balance (USD)') }}</span>
                                            <h6 class="invoice-subtotal-value">$ 00,000</h6>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- invoice action  -->
        <div class="col xl3 m4 s12">
            <div class="card invoice-action-wrapper mb-10">
                <div class="card-content">
                    <div class="invoice-action-btn">
                        <button class="btn btn-block waves-effect waves-light display-flex align-items-center justify-content-center" type="submit"
                                value="{{ isset($invoice) ? \App\Enums\InvoiceSaveStrategy::UPDATE : \App\Enums\InvoiceSaveStrategy::SAVE }}" name="submit">
                            {{ isset($invoice) ? __('Update Invoice') : __('Save Invoice') }}</button>
                    </div>
                    <div class="invoice-action-btn">
                        <button class="btn btn-block cyan waves-effect waves-light display-flex align-items-center justify-content-center" type="submit" value="{{ \App\Enums\InvoiceSaveStrategy::SEND }}" name="submit">
                            {{ __('Send') }}</button>
                    </div>
                    @if(!isset($invoice))
                    <div class="invoice-action-btn">
                        <button class="btn btn-block btn-light-indigo waves-effect waves-light display-flex align-items-center justify-content-center" type="submit" value="{{ \App\Enums\InvoiceSaveStrategy::DRAFT }}" name="submit">
                            {{ __('Draft') }}</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>