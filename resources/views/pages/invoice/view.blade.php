{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','App Invoice View' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- app invoice View Page -->
    <section class="invoice-view-wrapper section">
        <div class="row">
            <!-- invoice view page -->
            <div class="col xl9 m8 s12">
                <div class="card">
                    <div class="card-content invoice-print-area">
                        <!-- header section -->
                        <div class="row invoice-date-number">
                            <div class="col xl4 s12">
                                <span class="invoice-number mr-1">{{ $invoice->number }}</span>
                            </div>
                            <div class="col xl8 s12">
                                <div class="invoice-date display-flex align-items-center flex-wrap">
                                    <div class="mr-3">
                                        <small>Date Issue:</small>
                                        <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</span>
                                    </div>
                                    <div>
                                        <small>Date Due:</small>
                                        <span>{{ $invoice->plan_income_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- logo and title -->
                        <div class="row mt-3 invoice-logo-title">
                            <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
                                <img src="{{asset('images/gallery/pixinvent-logo.png')}}" alt="logo" height="46" width="164">
                            </div>
                            <div class="col m6 s12 pull-m6">
                                <h4 class="indigo-text">{{ __('Invoice') }}</h4>
                                <span>{{ $invoice->name }}</span>
                            </div>
                        </div>
                        <div class="divider mb-3 mt-3"></div>
                        <!-- invoice address and contact -->
                        <div class="row invoice-info">
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
                        </div>
                        <div class="divider mb-3 mt-3"></div>
                        <!-- product details table-->
                        <div class="invoice-product-details">
                            <table class="striped responsive-table">
                                <thead>
                                <tr>
                                    <th>{{ __('Item') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Qty') }}</th>
                                    <th>{{ __('Rate') }}</th>
                                    <th class="right-align">{{ __('Sum') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ \App\Enums\InvoiceItemType::getDescription($item->type) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ \App\Services\Formatter::currency($item->rate, $invoice->account->accountType) }}</td>
                                        <td class="indigo-text right-align">{{ \App\Services\Formatter::currency($item->sum, $invoice->account->accountType) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- invoice subtotal -->
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
                                            <h6 class="invoice-subtotal-value">{{ \App\Services\Formatter::currency($sum, $invoice->account->accountType) }}</h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Discount') }}</span>
                                            <h6 class="invoice-subtotal-value">- {{ \App\Services\Formatter::currency($invoice->discount, $invoice->account->accountType) }}</h6>
                                        </li>
                                        <li class="divider mt-2 mb-2"></li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Invoice Total') }}</span>
                                            <h6 class="invoice-subtotal-value">{{ \App\Services\Formatter::currency($invoice->total, $invoice->account->accountType) }}</h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">{{ __('Paid to date') }}</span>
                                            <h6 class="invoice-subtotal-value">- $ 00.00</h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- invoice action  -->
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper">
                    <div class="card-content">
                        <div class="invoice-action-btn">
                            <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-4">check</i>
                                <span class="text-nowrap">{{ __('Send Invoice') }}</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn btn-light-indigo waves-effect waves-light display-flex align-items-center justify-content-center invoice-print">
                                <i class="material-icons mr-5">print</i>
                                <span>{{ __('Print') }}</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>{{ __('Edit Invoice') }}</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">attach_money</i>
                                <span class="text-nowrap">{{ __('Add Payment') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/invoice.js') }}"></script>
@endsection
