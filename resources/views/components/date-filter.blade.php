<div class="date-filter" data-table="{{ $table }}" data-url="{{ $url }}">
    <div class="invoice-filter-action  input-field date-filter-block">
        <input type="text" id="from" name="start_date" class=" custom-datepicker-from" value="{{ $start ?? '' }}" readonly>
        <span class="custom-filter-label {{ isset($start) ? __('active') : __('') }}">From</span>
    </div>
    <div class="invoice-filter-action  input-field date-filter-block">
        <input type="text" id="to"  name="end_date" class=" custom-datepicker-to" value="{{ $end ?? '' }}" readonly>
        <span class="custom-filter-label {{ isset($end) ? __('active') : __('') }}">To</span>
    </div>
</div>
