<div class="date-filter row" data-table="{{ $table }}" data-url="{{ $url }}">
    <div class="col l6 invoice-filter-action">
        <input type="text" name="start_date" class="datepicker" placeholder="Start date" value="{{ $start ?? '' }}">
    </div>
    <div class="col l6 invoice-filter-action">
        <input type="text" name="end_date" class="datepicker" placeholder="End date" value="{{ $end ?? '' }}">
    </div>
</div>
