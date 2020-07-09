$(document).ready(function () {
  /********Account List ********/
  /* --------------------------- */

    // To append actions dropdown inside action-btn div
    var invoiceFilterAction = $(".invoice-filter-action");
    var invoiceCreateBtn = $(".invoice-create-btn");
    $(".dataTables_filter label").append($(".filter-btn").not(".invoice-filter-action"));
    $(".action-btns").append($(".filter-btn.invoice-filter-action"), invoiceFilterAction, invoiceCreateBtn);

});
