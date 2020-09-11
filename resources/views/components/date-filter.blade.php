<div class="date-filter" data-table="{{ $table }}" data-url="{{ $url }}">
    <div class="invoice-filter-action  input-field date-filter-block">
        <input type="text" name="start_date" class="datepicker" placeholder="Start date" value="{{ $start ?? '' }}">
        <label class="active">From</label>
    </div>
    <div class="invoice-filter-action  input-field date-filter-block">
        <input type="text"  name="end_date" class="datepicker" placeholder="End date" value="{{ $end ?? '' }}">
        <label class="active">To</label>
    </div>
</div>
