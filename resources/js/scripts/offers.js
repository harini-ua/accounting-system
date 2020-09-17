$(document).ready(function() {

  $('.offer-list-wrapper').each(function () {
    let $this = $(this);

    let dataTable = $('#offers-list-datatable').DataTable();

    dataTable.on('draw', function () {
      $('.tooltipped').tooltip();
    });

    let form = $('form#offers').DataTable();
  });

});
