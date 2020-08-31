<div class="internal-table">
    <div class="tr">
        <div class="td border-right">$ {{ \App\Services\Formatter::currency(random_int(10, 1000)) }}</div>
        <div class="td">$ {{ \App\Services\Formatter::currency(random_int(10, 100)) }}</div>
    </div>
    <div class="tr">
        <div class="td border-right">€ {{ \App\Services\Formatter::currency(random_int(10, 1000)) }}</div>
        <div class="td">€ {{ \App\Services\Formatter::currency(random_int(10, 100)) }}</div>
    </div>
    <div class="tr">
        <div class="td border-right">₴ {{ \App\Services\Formatter::currency(random_int(10, 10000)) }}</div>
        <div class="td">₴ {{ \App\Services\Formatter::currency(random_int(10, 100)) }}</div>
    </div>
</div>