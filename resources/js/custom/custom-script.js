/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
window.filters = window.filters || new Filters();

