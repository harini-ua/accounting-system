<div class="internal-table">
    <div class="tr">
        <div class="td">$ {{ \App\Services\Formatter::currency(random_int(10, 1000)) }}</div>
    </div>
    <div class="tr">
        <div class="td">€ {{ \App\Services\Formatter::currency(random_int(50, 2000)) }}</div>
    </div>
    <div class="tr">
        <div class="td">₴ {{ \App\Services\Formatter::currency(random_int(1000, 10000)) }}</div>
    </div>
</div>