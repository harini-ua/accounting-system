{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','App Invoice View' )

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')

    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-view-wrapper users-list-wrapper section">
        <div class="row">
            <div class="col xl9 m8 s12">
                <div class="card">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col m3">
                                    <a class="active" href="#invoice-tab">{{ __('Invoice') }}</a>
                                </li>
                                <li class="tab col m3">
                                    <a class="payments-tab" href="#payments-tab">{{ __('Payments') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div id="invoice-tab" class="col s12">
                            <div class="card-content invoice-print-area">
                                <div class="row invoice-date-number">
                                    <div class="col xl4 s12 pt-1 pb-1">
                                        <img src="{{ $image['src'] }}" alt="logo" height="{{ $image['height'] }}"
                                             width="{{ $image['width'] }}"/>
                                    </div>
                                    <div class="col xl8 s12">
                                        <div class="invoice-date display-flex align-items-center flex-wrap mb-1">
                                            <div class="mr-3">
                                                <small>Date Issue:</small>
                                                <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</span>
                                            </div>
                                            <div>
                                                <small>Date Due:</small>
                                                <span>{{ $invoice->plan_income_date }}</span>
                                            </div>
                                        </div>
                                        <span class="invoice-number float-right">{{ $invoice->number }}</span>
                                    </div>
                                </div>
                                <div class="row invoice-logo-title">
                                    @if($image)
                                        <div class="col m6 s12 invoice-logo display-flex pt-1 push-m6">

                                        </div>
                                    @endif
                                    <div class="col m6 s12 pull-m6 pt-2">
                                        <h4 class="indigo-text">{{ __('Invoice') }}</h4>
                                        <span>{{ $invoice->name }}</span>
                                    </div>
                                </div>
                                <div class="row invoice-info pt-3">
                                    <div class="col m6 s12">
                                        <div class="divider show-on-small hide-on-med-and-up mb-3"></div>
                                        <h6 class="invoice-to">{{ __('Bill To') }}</h6>
                                        <div class="invoice-address">
                                            <span>{{ $billTo['company'] }}</span>
                                        </div>
                                        <div class="invoice-address">
                                            <span>{{ $billTo['address'] }}</span>
                                        </div>
                                        <div class="invoice-address">
                                            <span>{{ $billTo['email'] }}</span>
                                        </div>
                                        <div class="invoice-address">
                                            <span>{{ $billTo['phone'] }}</span>
                                        </div>
                                    </div>
                                    <div class="col m6 s12">
                                        @if(count($billFrom))
                                            <h6 class="invoice-from">{{ __('Bill From') }}</h6>
                                            <div class="invoice-address">
                                                <span>{{ $billFrom['company'] }}</span>
                                            </div>
                                            <div class="invoice-address">
                                                <span>{{ $billFrom['address'] }}</span>
                                            </div>
                                            <div class="invoice-address">
                                                <span>{{ $billFrom['email'] }}</span>
                                            </div>
                                            <div class="invoice-address">
                                                <span>{{ $billFrom['phone'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="divider mb-3 mt-3"></div>
                                <div class="invoice-product-details">
                                    <table class="striped responsive-table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('Item') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th class="pr-2 pl-2">{{ __('Type') }}</th>
                                            <th class="pr-2 pl-2">{{ __('Qty') }}</th>
                                            <th class="pr-2 pl-2">{{ __('Rate') }}</th>
                                            <th class="right-align">{{ __('Sum') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->items as $item)
                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td class="pr-2 pl-2">{{ \App\Enums\InvoiceItemType::getDescription($item->type) }}</td>
                                                <td class="pr-2 pl-2">{{ $item->qty }}</td>
                                                <td class="pr-2 pl-2">{!! \App\Services\Formatter::currency($item->rate, $invoice->account->accountType->symbol, true) !!}</td>
                                                <td class="indigo-text right-align">{!! \App\Services\Formatter::currency($item->sum, $invoice->account->accountType->symbol, true) !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="divider mt-3 mb-3"></div>
                                <div class="invoice-subtotal">
                                    <div class="row">
                                        <div class="col m5 s12">
                                            <p>Thanks for your business.</p>
                                        </div>
                                        <div class="col xl4 m7 s12 offset-xl3">
                                            <ul>
                                                <li class="display-flex justify-content-between">
                                                    <span class="invoice-subtotal-title">{{ __('Subtotal') }}</span>
                                                    <h6 class="invoice-subtotal-value currency">{!! \App\Services\Formatter::currency($sum, $invoice->account->accountType->symbol, true) !!}</h6>
                                                </li>
                                                <li class="display-flex justify-content-between">
                                                    <span class="invoice-discount-title">{{ __('Discount') }}</span>
                                                    <h6 class="invoice-discount-value currency">
                                                        - {!! \App\Services\Formatter::currency($invoice->discount, $invoice->account->accountType->symbol, true) !!}</h6>
                                                </li>
                                                <li class="divider mt-2 mb-2"></li>
                                                <li class="display-flex justify-content-between">
                                                    <span class="invoice-total-title">{{ __('Invoice Total') }}</span>
                                                    <h6 class="invoice-total-value currency">{!! \App\Services\Formatter::currency($invoice->total, $invoice->account->accountType->symbol, true) !!}</h6>
                                                </li>
                                                <li class="display-flex justify-content-between">
                                                    <span class="invoice-paid-title">{{ __('Paid to date') }}</span>
                                                    <h6 class="invoice-paid-value currency"
                                                        data-paid="{{ $invoice->payments->sum('fee') }}">
                                                        - {!! \App\Services\Formatter::currency($invoice->payments->sum('fee'), $invoice->account->accountType->symbol, true) !!}</h6>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="payments-tab" class="col s12">
                            <div class="users-list-table">
                                <div class="card-content">
                                    <div class="payments-list-table responsive-table">
                                        {{ $dataTable->table() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col xl3 m4 s12" id="action">
                <div class="card invoice-action-wrapper">
                    <div class="card-content">
                        <div class="invoice-action-btn">
                            <a href="#"
                               class="btn btn-light-indigo waves-effect waves-light display-flex align-items-center justify-content-center invoice-print">
                                <span>{{ __('Print') }}</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a target="_blank" href="{{ route('invoices.download', $invoice) }}"
                               class="btn btn-light-indigo waves-effect waves-light display-flex align-items-center justify-content-center invoice-download">
                                <span>{{ __('Download') }}</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('invoices.edit', $invoice) }}"
                               class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>{{ __('Edit Invoice') }}</span>
                            </a>
                        </div>
                        <div id="payment-button" class="invoice-action-btn">
                            <span
                                class="btn-block btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <span>{{ __('Add Payment') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-sidebar-form id="payment" title="{{ __('Payment') }}" :model="$invoice" button="{{ __('Create') }}">
        <x-date name="date" title="{{ __('Date of payment') }}" :model="$invoice"></x-date>
        <x-input name="fee" title="{{ __('Fee') }}" :model="$invoice"></x-input>
        <x-input name="received_sum" title="{{ __('Received sum') }}" :model="$invoice"></x-input>
    </x-sidebar-form>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{ asset('js/scripts/invoice.js') }}"></script>
    <script>
        const numberFormat = @json(array_values(config('general.number.format')));
    </script>
@endsection
