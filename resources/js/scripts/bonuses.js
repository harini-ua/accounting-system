jQuery(document).ready(function ($) {
  /* Bonus list */
  /* ------------*/

  $('.bonus-list-wrapper').each(function () {
    let $this = $(this);
    let dataTable = $('#bonuses-list-datatable').DataTable();

    $('#bonuses-list-datatable tbody').on( 'mouseenter', 'td', function () {
      const colIdx = dataTable.cell(this).index().column;

      $(dataTable.cells().nodes()).removeClass('highlight');
      $(dataTable.column(colIdx).nodes()).addClass('highlight');
    });
  });

  $('.dataTable thead th').css('cursor', 'pointer').removeAttr('title');
})