$(document).ready(function () {

    // Custom Filters
    class Filters
    {
        constructor() {
            this.filters = {};
        }
        get(name) {
            return this.filters[name];
        }
        set(name, filter) {
            if (filter) {
                this.filters = Object.assign({}, this.filters, {
                    [name]: filter,
                })
            } else {
                delete(this.filters[name]);
            }
        }
        url(route) {
            const url = new URL(route);
            for (let name in this.filters) {
                url.searchParams.set(name, this.filters[name]);
            }
            return url.href;
        }
    }
    const filters = new Filters();

    // Filters
    const filterButtons = $(".filter-btn");
    filterButtons.each(i => {
        const filterButton = $(filterButtons[i]);
        const route = filterButton.attr('data-url');
        const name = filterButton.attr('data-name');
        const table = $('#' + filterButton.attr('data-table')).DataTable();

        filterButton.on('click', '.option', function(e) {
            e.preventDefault();
            filters.set(name, this.dataset.id);
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

    $('#vacations-table').on('xhr.dt', function() {
        $(this).find('thead th a[data-month-link]').attr('href', function(i, val) {
            let year = filters.get('year_filter') || (new Date()).getFullYear();
            return val.replace(/\/(\d+)\//, function() {
                return '/' + year + '/';
            });
        });
    });
    $('#vacations-table').on('draw.dt', function() {
        $(this).find('td span[data-color]').closest('td').attr('style', 'background-color: #f5f2ff !important;');
    });

});
