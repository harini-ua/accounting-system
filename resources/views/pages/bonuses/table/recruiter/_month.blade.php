<div class="internal-table">
    @foreach($data as $code => $values)
    <div class="tr">
        <div class="td">{{ \App\Services\Formatter::currency(array_sum($values), $currency[$code]) }}</div>
    </div>
    @endforeach
</div>