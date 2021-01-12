<div class="date-filter" data-table="{{ $table }}" data-url="{{ $url }}">
    <div class="invoice-filter-action  input-field date-filter-block">
        <input type="text" id="from" name="start_date" class=" custom-datepicker-from" placeholder="Start date" value="{{ $start ?? '' }}">
        <label class="active">From</label>
    </div>
    <div class="invoice-filter-action  input-field date-filter-block">
        <input type="text" id="to"  name="end_date" class=" custom-datepicker-to" placeholder="End date" value="{{ $end ?? '' }}">
        <label class="active">To</label>
    </div>
</div>
