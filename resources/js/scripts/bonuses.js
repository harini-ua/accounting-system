jQuery(document).ready(function ($) {
  /* Bonus list */
  /* ------------*/

  $('.bonus-list-wrapper').each(function () {
    let $this = $(this);
    let dataTable = $('#bonuses-list-datatable').DataTable();

    dataTable.on('draw', function () {
      let year = window.filters.get('year_filter');
      if (year !== undefined) {
        $this.find('.bonuses-year').data('year', year).html(year)
      }
    });

    $this.find('.tabs .tab a').not('.active').on('click', function () {
      let url = $(this).data('bonuses-href');
      $(location).attr('href', url);
    });

    $('#bonuses-list-datatable tbody').on( 'mouseenter', 'td', function () {
      const colIdx = dataTable.cell(this).index().column;

      $(dataTable.cells().nodes()).removeClass('highlight');
      $(dataTable.column(colIdx).nodes()).addClass('highlight');
    });
  });

  $('.dataTable thead th').css('cursor', 'pointer').removeAttr('title');
})