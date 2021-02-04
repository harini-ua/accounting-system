jQuery(document).ready(function ($) {
  /* Salary month */
  /* ------------*/
  $('.salary-month-list-wrapper').each(function () {
    let $this = $(this);

    let dataTable = $('#salary-month-list-datatable').DataTable();

    route();
    dataTable.on('draw', function () {
      $('#salary-month-list-datatable thead tr.double-head').remove();

      $('#salary-month-list-datatable thead tr')
        .before(`
      <tr class="double-head">
        <th colspan="3"></th>
        <th colspan="2" class="center-align border">Worked</th>
        <th colspan="2"></th>
        <th colspan="2" class="center-align border">Overtime</th>
        <th colspan="7"></th>
        <th colspan="2" class="center-align border">Total</th>
        <th colspan="2" class="center-align border">Payment</th>
        <th></th>
      </tr>
      `);

      $('.tooltipped').tooltip();
    });

    //..
  });
});