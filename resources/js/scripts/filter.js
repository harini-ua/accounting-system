$(document).ready(function () {

    const filterButton = $(".filter-btn");
    const route = filterButton.attr('data-url');
    const name = filterButton.attr('data-name');
    const table = $('#' + filterButton.attr('data-table')).DataTable();

    filterButton.on('click', '.option', function(e) {
        e.preventDefault();
        let url = this.dataset.id == 'all' ? route : route + '?' + name + '=' + this.dataset.id;
        table.ajax.url(url).load();
    });

});
