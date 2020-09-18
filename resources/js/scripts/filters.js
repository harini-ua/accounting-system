$(document).ready(function () {

    // Filters
    const filterButtons = $(".filter-btn");
    filterButtons.each(i => {
        const filterButton = $(filterButtons[i]);
        const route = filterButton.attr('data-url');
        const name = filterButton.attr('data-name');
        const table = $('#' + filterButton.attr('data-table')).DataTable();

        filterButton.on('change', '.select-filters', function(e) {
            e.preventDefault();
            filters.set(name, this.value);
            table.ajax.url(filters.url(route)).load();
            $(document).trigger({
                type: 'filterChange',
                filters: filters
            });
        });
    });

    // Date filter
    const dateFilter = $(".date-filter");
    const route = dateFilter.attr('data-url') ? dateFilter.attr('data-url') : location.href;
    const table = $('#' + dateFilter.attr('data-table')).DataTable();
    dateFilter.find("input").on('change', function(e) {
        e.preventDefault();
        const name = this.getAttribute('name');
        filters.set(name, this.value);
        table.ajax.url(filters.url(route)).load();
        $(document).trigger({
            type: 'filterChange',
            filters: filters
        });
    });

    // Checkbox filter
    $('.checkbox-filter input').on('change', function(e) {
        e.preventDefault();
        const checkboxFilter = $(this).closest('.checkbox-filter');
        const route = checkboxFilter.attr('data-url') ? checkboxFilter.attr('data-url') : location.href;
        const table = $('#' + checkboxFilter.attr('data-table')).DataTable();
        const name = this.getAttribute('name');

        filters.set(name, this.checked ? this.value : null);
        table.ajax.url(filters.url(route)).load();
        $(document).trigger({
            type: 'filterChange',
            filters: filters
        });
    });

    // Totals
    $(document).on('filterChange', function(e) {
        $.getJSON(e.filters.url(window.location.origin + '/totals'), function(data) {
            $('.totals-list').html(function() {
                const template = $(this).find('.col').first();
                const source = $(this).attr('data-source');
                const content = $(this).find('.totals-content');

                content.html('');
                data.forEach(item => {
                    const element = template.clone();
                    element.find('.card-content').text(item.name + ': ' + item[source])
                    content.append(element);
                });
            });
        });
    });

    $('.select2').select2().trigger('change')

});
