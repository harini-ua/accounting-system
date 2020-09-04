<div class="internal-table">
    @foreach($data as $code => $values)
    <div class="tr">
        @php
        $reseived = \App\Services\Formatter::currency($values[0], $currency[$code]);
        $bonuses = \App\Services\Formatter::currency($values[1], $currency[$code]);
        @endphp
        <div class="td {{ ((int) $values[1]) ? 'tooltipped' : '' }}"
             @if((int) $values[1]) data-position="right" @endif
             @if((int) $values[1])  data-tooltip="{{__("Reseived").': '.$reseived.'<br>'.__("Bonuses").': '.$bonuses}}" @endif
        >
            {{ \App\Services\Formatter::currency($values[1], $currency[$code]) }}
        </div>
    </div>
    @endforeach
</div>