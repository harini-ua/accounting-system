$(document).ready(function () {
  $('.salary-review-list-wrapper').each(function () {
    let $this = $(this);

    let dataTable = $('#salary-review-list-datatable').DataTable();

    route();
    dataTable.on('draw', function () {
      $('#salary-review-list-datatable thead tr.quarter-head').remove();

      $('#salary-review-list-datatable thead tr')
        .before(`
      <tr class="quarter-head">
        <th colspan="2"></th>
        <th colspan="3" class="center-align border"><a class="qr1 underline" target="_blank">I Quarter</a></th>
        <th colspan="3" class="center-align border"><a class="qr2 underline" target="_blank">II Quarter</a></th>
        <th colspan="3" class="center-align border"><a class="qr3 underline" target="_blank">III Quarter</a></th>
        <th colspan="3" class="center-align border"><a class="qr4 underline" target="_blank">IV Quarter</a></th>
        <th colspan="2" class="center-align border"><a class="year underline" href="javascript:void(0);"></a></th>
      </tr>
      `);

      let year = window.filters.get('year_filter');
      $('a.qr1').attr('href', route('salary-reviews.byQuarter', [year, 1]));
      $('a.qr2').attr('href', route('salary-reviews.byQuarter', [year, 2]));
      $('a.qr3').attr('href', route('salary-reviews.byQuarter', [year, 3]));
      $('a.qr4').attr('href', route('salary-reviews.byQuarter', [year, 4]));

      $('a.year').text(year);

      $('.tooltipped').tooltip();
    });

    //..
  });

  $('.salary-review-create-wrapper, .salary-review-edit-wrapper').each(function () {
    let $this = $(this);

    let reason = $this.find('form select#reason');
    reason.on('change', function () {
      let selected = $(this);
      $('#prof_growth')
        .prop('disabled', (selected.val() !== 'PROFESSIONAL_GROWTH'))
        .closest('.input-field')
        .find('.select-dropdown')
        .prop('disabled', (selected.val() !== 'PROFESSIONAL_GROWTH'))
      ;
    });
  });
});
