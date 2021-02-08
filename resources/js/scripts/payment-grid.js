jQuery(document).ready(function ($) {
  /* Payment grid */
  /* ------------*/

  $('.payment-grid-list-wrapper').each(function () {
    let $this = $(this);
    let dataTable = $('#payment-grid-list-datatable').DataTable();

    $('#payment-grid-list-datatable tbody').on( 'mouseenter', 'td', function () {
      const colIdx = dataTable.cell(this).index().column;

      $(dataTable.cells().nodes()).removeClass('highlight');
      $(dataTable.column(colIdx).nodes()).addClass('highlight');
    });

    $('.dataTable thead th').css('cursor', 'default').removeAttr('title');
  });
});