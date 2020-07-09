$(document).ready(function () {

    const filterButtons = $(".filter-btn");
    const filters = window.filters;

    filterButtons.each(i => {
        const filterButton = $(filterButtons[i]);
        const route = filterButton.attr('data-url');
        const name = filterButton.attr('data-name');
        const table = $('#' + filterButton.attr('data-table')).DataTable();

        filterButton.on('click', '.option', function(e) {
            e.preventDefault();
            filters.set(name, this.dataset.id);
            table.ajax.url(filters.url(route)).load();
        });
    });

});
