$(document).ready(function() {
  $('.offer-list-wrapper').each(function () {
    let $this = $(this);

    let dataTable = $('#offers-list-datatable').DataTable();

    dataTable.on('draw', function () {
      $('.tooltipped').tooltip();
    });
  });

  $('.offer-create-wrapper, .offer-update-wrapper').each(function () {
    let $this = $(this);
    let form = $this.find('form#offers');
    let employee = $this.find('form select#employee_id');

    employee.on('change', function () {
      let selected = $(this);

      $.ajax({
        url: route('people.info', selected.val()),
        type: "GET",
        processData: false,
        contentType: false,
        success: resp => {
          $this.find("input[name='bonuses']").val(resp.bonuses_reward).focus();
          $this.find("input[name='start_date']").val(resp.start_date).focus();
          $this.find("input[name='salary']").val(resp.salary).focus();
          $this.find("input[name='trial_period']").val(resp.trial_period || 2).focus();
          $this.find("select[name='employee_id']").focus();
        }
      });
    })
  });
});
