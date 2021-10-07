jQuery(document).ready(function ($) {

  $('.final-payslip-list-wrapper').each(function () {
    let $this = $(this);

    let dataTable = $('#final-payslip-list-datatable').DataTable();

    dataTable.on('draw', function () {
      $('#final-payslip-list-datatable thead tr.additional-head').remove();

      $('#final-payslip-list-datatable thead tr')
        .before(`
      <tr class="additional-head">
        <th></th>
        <th colspan="2" class="center-align border">Number Days</th>
        <th colspan="2" class="center-align border">Number Hours</th>
      </tr>
      `);
    });
  });

  $('.final-payslip-form-wrapper').each(function () {
    let $this = $(this);
    updateLastWorkingDay();

    let person = getUrlParameter('person_id');
    if(!person) {
        $('[name="last_working_day"]').attr("disabled", 'disabled')
    }

    $('[name="person_id"]').change(function() {
      let params = {}
      params.changed = 'person';
      params.person_id = $('[name="person_id"]').val();

      let lastWorkingDay = $('[name="last_working_day"]').val();
      if (lastWorkingDay) {
        params.last_working_day = lastWorkingDay;
      }

      $.pjax({
        url: makeUrl({
          params: params
        }),
        container: '[data-pjax]'
      });

      let personId = $('[name="person_id"]').val();
      if (personId) {
        $('[name="last_working_day"]')
          .prop( "disabled", false )
          .focus();
      }
    });

    $('[name="last_working_day"]').change(function() {
      let params = {}
      params.changed = 'date';
      params.person_id = $('[name="person_id"]').val();
      params.last_working_day = $('[name="last_working_day"]').val();

      console.log('last_working_day: ', params);

      $.pjax({
        url: makeUrl({
          params: params
        }),
        container: '[data-pjax]'
      });
    });

    $(document).on('pjax:complete', function() {
      M.updateTextFields();
      $('[name="wallet_id"], [name="account_id"]').select2();

      updateLastWorkingDay();
    });

    function updateLastWorkingDay() {
      let lastDay = $('[name="last_working_day_hidden"]').val();

      if (lastDay) {
        $('[name="last_working_day"]')
          .datepicker("setDate", moment(lastDay).format('MM/DD/YYYY'))
          .val(moment(lastDay).format('DD-MM-YYYY'))
          .prop( "disabled", false )
          .focus();

        updateURL('last_working_day', moment(lastDay).format('DD-MM-YYYY'));
      }
    }

    function updateURL(name, value)
    {
      let queryParams = new URLSearchParams(window.location.search);
      queryParams.set(name, value);
      history.replaceState(null, null, "?"+queryParams.toString());
    }

    function makeUrl(options) {
      const url = new URL(options.route ? options.route : window.location.href);
      for (let name in options.params) {
        url.searchParams.set(name, options.params[name]);
      }
      return url.href;
    }

    $('#final-payslip-form').on('keyup', 'input[name="worked_hours"]', function() {
      updateTotal();
    });

    $('#final-payslip-form').on('keyup', '[name="monthly_bonus"], [name="tax_compensation"], [name="other_compensation"]', function() {
      updateTotal();
    });

    $('#final-payslip-form').on('keyup', '[name="fines"]', function() {
      let val = parseFloat($('[name="fines"]').val());
      $('[name="fines"]').val(val ? -Math.abs(val) : null);
      updateTotal();
    });

    function updateTotal()
    {
      let total = 0;
      let convertedValue = 0;
      for (let field in fields) {
          convertedValue += getConvertedFieldValue(field);
          total += convertedValue;
      }
      total = Number(total + Number($('#person-info').attr('data-total-bonuses'))).toFixed(2);
      $('[name="total_usd"]').val(total);
      $('[name="total_uah"]').val(Number(convert('USD', 'UAH', total)).toFixed(2));

      M.updateTextFields();
    }

    function convert(from, to, value)
    {
      return value * currencies[from] / currencies[to];
    }

    function convertToUSD(currency, value)
    {
      return convert(currency, 'USD', value);
    }

    function getConvertedFieldValue(field)
    {
      return convertToUSD(fields[field], Number($('[name="'+field+'"]').val()));
    }

  });

  $('.final-payslip-view-wrapper').each(function () {
    let $this = $(this);
  });

});
