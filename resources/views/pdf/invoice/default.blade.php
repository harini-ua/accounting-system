@extends('pdf.invoice.layouts.main')

@section('content')
    <table>
        <tr>
            <td colspan="3">
                <table>
                    <tr>
                        <td style="width: 50%;">
                            <h4>{{ $invoice->number }}</h4>
                        </td>
                        <td style="width: 25%; text-align: right" >
                            <small>Date Issue:</small>
                            <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</span>
                        </td>
                        <td style="width: 25%; text-align: right">
                            <small>Date Due:</small>
                            <span>{{ $invoice->plan_income_date }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br/>
                <table>
                    <tr>
                        <td style="width: 70%;">
                            <h2 class="indigo-text">{{ __('Invoice') }}</h2>
                            <span>{{ $invoice->name }}</span>
                        </td>
                        <td style="width: 30%;" rowspan="2">
                            @if($image)
                                <img src="{{ $image['src'] }}" alt="logo" height="{{ $image['height'] }}" width="{{ $image['width'] }}" />
                            @endif
                        </td>
                    </tr>
                    <tr><td></td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br/>
                <table>
                    <tr>
                        <td style="width: 50%;"><h4>{{ count($billFrom) ? __('Bill From') : null }}</h4></td>
                        <td style="width: 50%;"><h4>{{ __('Bill To') }}</h4></td>
                    </tr>
                    <tr>
                        <td>{{ count($billFrom) ? $billFrom['company'] : null }}</td>
                        <td>{{ $billTo['company'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ count($billFrom) ? $billFrom['address'] : null }}</td>
                        <td>{{ $billTo['address'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ count($billFrom) ? $billFrom['email'] : null }}</td>
                        <td>{{ $billTo['email'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ count($billFrom) ? $billFrom['phone'] : null }}</td>
                        <td>{{ $billTo['phone'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br/><br/>
                <table>
                    <tr>
                        <td style="text-align: left">{{ __('Item') }}</td>
                        <td style="text-align: left">{{ __('Description') }}</td>
                        <td style="text-align: left">{{ __('Type') }}</td>
                        <td style="text-align: left">{{ __('Qty') }}</td>
                        <td style="text-align: left">{{ __('Rate') }}</td>
                        <td style="text-align: right" class="right-align">{{ __('Sum') }}</td>
                    </tr>
                    <tbody>
                    @foreach($invoice->items as $i => $item)
                        <tr @if($i%2 === 0) style="background-color: lightgrey" @endif>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ \App\Enums\InvoiceItemType::getDescription($item->type) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ \App\Services\Formatter::currency($item->rate, $invoice->account->accountType->symbol) }}</td>
                            <td style="text-align: right" class="indigo-text right-align">{{ \App\Services\Formatter::currency($item->sum, $invoice->account->accountType->symbol) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br/>
            </td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" colspan="2">
                <br/>
                <table style="text-align: right;">
                    <tr>
                        <td>{{ __('Subtotal') }}</td>
                        <td style="">{{ \App\Services\Formatter::currency($sum, $invoice->account->accountType->symbol) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Discount') }}</td>
                        <td>- {{ \App\Services\Formatter::currency($invoice->discount, $invoice->account->accountType->symbol) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Invoice Total') }}</td>
                        <td>{{ \App\Services\Formatter::currency($invoice->total, $invoice->account->accountType->symbol) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Paid to date') }}</td>
                        <td>- {{ \App\Services\Formatter::currency($invoice->payments->sum('fee'), $invoice->account->accountType->symbol) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection