<div class="internal-table">
    @foreach($data as $code => $values)
    <div class="tr">
        @foreach($values as $key => $value)
            <div class="td {{ (!$loop->last) ? 'border-right' : '' }}">{{ \App\Services\Formatter::currency($value, $currency[$code]) }}</div>
        @endforeach
    </div>
    @endforeach
</div>