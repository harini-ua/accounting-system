@extends('pdf.payslip.layouts.main')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pdf/payslip.css')}}">
@endsection

@section('content')
    <div id="payslip-list">
    @php($columns = config('general.payslip.per_page.available')[config('general.payslip.per_page.default')][1])
    @foreach($salaryPayments as $page => $rows)
        <table class="table-list">
        @foreach($rows as $r => $col)
            <tr>
            @foreach($col as $c => $payslip)
                <td class="{{ ($c+1 < $columns) ? 'border-right' : '' }} {{ ($r+1 < $rows->count()) ? 'border-bottom' : '' }} {{ ($r+1 !== 1) ? 'padding-top-10' : '' }}">
                    @include('pdf.payslip.item')
                </td>
            @endforeach
            @if($fewColumn)
                @php($more = $columns - $salaryPayments->count())
                @for($i = 1; $i <= $more; $i++)
                <td></td>
                @endfor
            @endif
            </tr>
        @endforeach
        </table>
        @if($page+1 < $salaryPayments->count())
            <div class="page-break"></div>
        @endif
    @endforeach
    </div>
@endsection
