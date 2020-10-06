<div class="internal-table">
    @foreach($bonuses as $code => $value)
        <div class="tr">
            <div class="td">
                {{ \App\Services\Formatter::currency($value, \App\Enums\Currency::symbol($code)) }}
            </div>
        </div>
    @endforeach
</div>
