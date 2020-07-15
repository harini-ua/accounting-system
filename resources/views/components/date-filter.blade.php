<div class="date-filter" data-table="{{ $table }}" data-url="{{ $url }}">
    <div class="invoice-filter-action mr-3">
        <input type="text" name="start_date" class="datepicker" placeholder="Start date" value="{{ $start ?? '' }}">
    </div>
    <div class="invoice-filter-action mr-3">
        <input type="text" name="end_date" class="datepicker" placeholder="End date" value="{{ $end ?? '' }}">
    </div>
</div>
