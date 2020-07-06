$(document).ready(function () {

    const filterButton = $(".filter-btn");
    const route = filterButton.attr('data-url');
    const name = filterButton.attr('data-name');
    const table = $('#' + filterButton.attr('data-table')).DataTable();
    const filters = window.filters;

    filterButton.on('click', '.option', function(e) {
        e.preventDefault();
        filters.set(name, this.dataset.id);
        table.ajax.url(filters.url(route)).load();
    });

});
