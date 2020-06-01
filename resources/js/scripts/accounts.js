$(document).ready(function () {
  /********Account List ********/
  /* --------------------------- */
    var table = $("#accounts-table").DataTable();

    // To append actions dropdown inside action-btn div
    var invoiceFilterAction = $(".invoice-filter-action");
    var invoiceCreateBtn = $(".invoice-create-btn");
    var filterButton = $(".filter-btn");
    $(".action-btns").append(invoiceFilterAction, invoiceCreateBtn);
    $(".dataTables_filter label").append(filterButton);

    filterButton.on('click', '.option', function(e) {
        e.preventDefault();
        let url = this.dataset.id == 'all' ? '/accounts' : '/accounts?wallet_filter=' + this.dataset.id;
        table.ajax.url(url).load();
    });

});
