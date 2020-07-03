$(document).ready(function () {
  /********Account List ********/
  /* --------------------------- */

    // To append actions dropdown inside action-btn div
    var invoiceFilterAction = $(".invoice-filter-action");
    var invoiceCreateBtn = $(".invoice-create-btn");
    var filterButton = $(".filter-btn");
    $(".action-btns").append(invoiceFilterAction, invoiceCreateBtn);
    $(".dataTables_filter label").append(filterButton);

});
