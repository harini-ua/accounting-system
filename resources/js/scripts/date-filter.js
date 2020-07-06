$(document).ready(function () {
    const filter = $(".date-filter");
    const route = filter.attr('data-url') ? filter.attr('data-url') : location.href;
    const table = $('#' + filter.attr('data-table')).DataTable();
    const filters = window.filters;

    $(".date-filter input").on('change', function(e) {
        e.preventDefault();
        const name = this.getAttribute('name');
        filters.set(name, this.value);
        table.ajax.url(filters.url(route)).load();
    });

});
