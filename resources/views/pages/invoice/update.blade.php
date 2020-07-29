{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Update Invoice'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <!-- invoice view page -->
            <div class="col xl9 m8 s12">
                <div class="card">
                    <div class="card-content px-36">
                        <!-- header section -->
                        <div class="row mb-3">
                            <div class="col xl4 m12 display-flex align-items-center">
                                <input type="text" value="{{ $invoice->number }}" placeholder="{{ __('INV-00000') }}" disabled>
                            </div>
                            <div class="col xl8 m12">
                                <div class="invoice-date-picker display-flex align-items-center">
                                    <div class="display-flex align-items-center">
                                        <small>{{ __('Invoice Date') }}</small>
                                        <div class="display-flex ml-4">
                                            <input type="text" id="date" value="{{ $invoice->date }}" class="datepicker mr-2 mb-1" placeholder="{{ __('Select Date') }}">
                                        </div>
                                    </div>
                                    <div class="display-flex align-items-center">
                                        <small>{{ __('Plan Income Date') }}</small>
                                        <div class="display-flex ml-4">
                                            <input type="text" id="plan_income_date" value="{{ $invoice->plan_income_date }}" class="datepicker mb-1" placeholder="{{ __('Select Date') }}">
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
                                    <input id="name" value="{{ $invoice->name }}" type="text">
                                    <label for="name" data-error="wrong" data-success="right">{{ __('Invoice Name') }}</label>
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
                                />
                            </div>
                        </div>
                        <div class="divider mb-3 mt-3"></div>
                        <!-- product details table-->
                        <div class="invoice-product-details mb-3">
                            <div class="invoice-item-repeater">
                                <div data-repeater-list="group-a">
                                @foreach($invoice->items as $key => $item)
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
                                                    <input type="text" name="items['{{ $key }}']title" class="item-title" value="{{ $item->title }}">
                                                    <label for="title">{{ __('Item Title') }}</label>
                                                </div>
                                                <div class="col m3 s12 input-field">
                                                    <select name="items['{{ $key }}']type" class="select2-icons invoice-item-select browser-default item-type">
                                                        @foreach(\App\Enums\InvoiceItemType::toSelectArray() as $key => $type)
                                                            <option value="{{ $key }}" {{ $item->type == $key ? 'selected' : '-' }}
                                                                    data-icon="{{ \App\Enums\InvoiceItemType::getIcon($key) }}"
                                                            >{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col m2 s12 input-field">
                                                    <input type="text" name="items['{{ $key }}']qty" class="item-qty"
                                                           {{ $item->type == \App\Enums\InvoiceItemType::FIXED ? 'disabled' : '' }}
                                                           value="{{ $item->qty }}" placeholder="0">
                                                </div>
                                                <div class="col m2 s12 input-field">
                                                    <input type="text" name="items['{{ $key }}']rate" class="item-rate" value="{{ $item->rate }}" placeholder="$ 0.00">
                                                </div>
                                                <div class="col m2 s12 input-field">
                                                    <input type="text" name="items['{{ $key }}']sum" class="item-sum" value="{{ $item->sum }}"  placeholder="$ 0.00" disabled>
                                                </div>
                                                <div class="col m12 s12 input-field">
                                                    <textarea name="items['{{ $key }}']description" class="item-description materialize-textarea">{{ $item->description }}</textarea>
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
                                @endforeach
                                </div>
                                <div class="input-field">
                                    <button class="btn invoice-repeat-btn" data-repeater-create type="button">
                                        <i class="material-icons left">add</i>
                                        <span>{{ __('Add Item') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- invoice subtotal -->
                        <div class="invoice-subtotal">
                            <div class="row">
                                <div class="col m5 s12">
                                    <div class="input-field">
                                        <input id="discount" type="text" value="{{ $invoice->discount }}" placeholder="{{ __('0.00') }}">
                                        <label for="discount">{{ __('Discount') }}</label>
                                    </div>
                                    <div class="input-field">
                                        <select id="sales_manager_id" class="select2 invoice-item-select browser-default">
                                            <option value="">{{ __('- Select Sales Manager -') }}</option>
                                            @foreach($sales as $user)
                                                <option value="{{ $user->id }}" {{ $invoice->sales_manager_id == $user->id  ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col xl4 m7 s12 offset-xl3">
                                    <ul>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Subtotal') }}</span>
                                            <h6 class="invoice-subtotal-value">$ {{ $invoice->items->sum('sum') }}</h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Discount') }}</span>
                                            <h6 class="invoice-subtotal-value">- $ {{ $invoice->discount }}</h6>
                                        </li>
                                        <li>
                                            <div class="divider mt-2 mb-2"></div>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Invoice Total') }}</span>
                                            <h6 class="invoice-subtotal-value">$ {{ $invoice->items->sum('sum') - $invoice->discount }}</h6>
                                        </li>
                                        @if($invoice)
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Paid to date') }}</span>
                                            <h6 class="invoice-subtotal-value">- $ {{ $invoice->payments->sum('fee') }}</h6>
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
                            <a class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <span class="responsive-text">{{ __('Save Invoice') }}</span>
                            </a>
                        </div>
                        <div class="row invoice-action-btn">
                            <div class="col s6 preview">
                                <a class="btn btn-light-indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                    <i class="material-icons mr-4">class</i>
                                    <span class="responsive-text">{{ __('Draft') }}</span>
                                </a>
                            </div>
                            <div class="col s6 save">
                                <a class="btn cyan waves-effect waves-light display-flex align-items-center justify-content-center">
                                    <i class="material-icons mr-4">send</i>
                                    <span class="responsive-text">{{ __('Send') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- client update ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/form_repeater/jquery.repeater.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/linked-selects.js')}}"></script>
    <script src="{{asset('js/scripts/invoice.js')}}"></script>
@endsection
