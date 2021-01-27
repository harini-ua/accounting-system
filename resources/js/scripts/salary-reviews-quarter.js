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
        <th colspan="3" class="center-align border"><a class="quarter underline" target="_blank"></a></th>
        <th colspan="2" class="center-align"><a class="year underline" href="javascript:void(0);"></a></th>
      </tr>
      `);

      let url = window.location.href;
      let quarter = url.substr(url.lastIndexOf('/') + 1);
      $('a.quarter').text(romanize(quarter) + ' Quarter');

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
