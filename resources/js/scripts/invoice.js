jQuery(document).ready(function ($) {
  /* Invoice edit and create */
  /* ------------*/

  $('.invoice-view-wrapper').each(function () {
    let $this = $(this);

    // use default format
    if (typeof numberFormat !== 'undefined') {
      let numberFormat = [2, ',', ' '];
    }

    let invoice = {
      btn: {
        print: $this.find(".invoice-print"),
      }
    };

    invoice.btn.print.on("click", function () {
      window.print();
    })

    function handleSidebar(id, callback = null)
    {
      const sidebar = $('#'+id+'-sidebar');
      $('.contact-compose-sidebar .close-icon').click(function() {
        sidebar.removeClass('show');
      });

      $('#'+id+'-button').click(function() {
        sidebar.addClass('show');
      });

      sidebar.find('button').click(function(e) {
        const form = document.forms[id];
        const formData = new FormData(form);
        $.ajax({
          url: form.getAttribute('action'),
          type: "POST",
          processData: false,
          contentType: false,
          data: formData,
          success: resp => {
            sidebar.removeClass('show');
            swal({
              title : resp.success === false ? 'Error!' : 'Successfully!',
              text  : resp.message,
              type  : resp.success === false ? 'error' : 'success',
            });

            updateViewInvoice(form.elements);

            if (typeof callback === 'function') {
              callback(form);
            }

            form.reset();
          },
          error: response => {
            let text = 'Please try again later!';
            if (response.responseJSON) {
              const resp = response.responseJSON;
              if (resp.message) {
                text = resp.message;
              }
              if (resp.errors) {
                let errors = '';
                for (let prop in resp.errors) {
                  errors += '<br>' + resp.errors[prop][0];
                }
                text += errors;
              }
            }
            swal('Error!', text, 'error');
          }
        });
      });
    }

    handleSidebar('payment');

    function updateViewInvoice(elements)
    {
      Array.prototype.forEach.call(elements, element => {
        if (element.name === 'fee') {
          $invoicePaidValue = $('.invoice-paid-value.currency .value');
          $paidToDate = $invoicePaidValue.text().replace(/,/g, '.');
          $paidToDate = parseFloat($paidToDate) + parseFloat(element.value);
          $paidToDate = number_format($paidToDate,...numberFormat);
          $invoicePaidValue.text($paidToDate);
        }
      });
    }
  });

  $('.invoice-edit-wrapper').each(function () {
    const $this = $(this);

    // use default format
    if (typeof numberFormat !== 'undefined') {
      const numberFormat = [2, ',', ' '];
    }

    let invoice = {
      type: {
        HOURLY: 'HOURLY',
        FIXED: 'FIXED',
      },
      account: $this.find("#account_id"),
      currencySymbol: $this.find(".currency .symbol"),
      items: $this.find(".invoice-item-repeater .invoice-item"),
      item: {
        type: $this.find(".invoice-item-repeater .invoice-item .item-type"),
        qty: $this.find(".invoice-item-repeater .invoice-item .item-qty"),
        rate: $this.find(".invoice-item-repeater .invoice-item .item-rate"),
        sum: $this.find(".invoice-item-repeater .invoice-item .item-sum"),
        raw: $this.find(".invoice-item-repeater .invoice-item .item-raw"),
      },
      subtotal: $this.find(".invoice-subtotal-value .value"),
      discount: {
        input: $this.find(".input-field input[name='discount']"),
        value: $this.find(".invoice-discount-value .value"),
      },
      total: $this.find(".invoice-total-value .value"),
    };

    /* item repeater */
    var uniqueId = 1;
    if ($this.find(".invoice-item-repeater").length) {
      $this.find(".invoice-item-repeater").repeater({
        show: function () {
          /* Assign unique id to new dropdown */
          $(this).find(".dropdown-button").attr("data-target", "dropdown-discount" + uniqueId + "");
          $(this).find(".dropdown-content").attr("id", "dropdown-discount" + uniqueId + "");
          uniqueId++;
          /* showing the new repeater */
          $(this).slideDown();
        },
        hide: function (deleteElement) {
          $(this).slideUp(deleteElement);
        }
      });
    }

    invoice.account.on("change", function (e) {
      invoice.currencySymbol.text(accountCurrency[$(this).val()]);
    });

    invoice.item.type.on("change", function (e) {
      let $item = $(this).closest('.invoice-item');
      let type = $(this).val();

      $item.find('.item-qty')
           .prop("disabled", (type === invoice.type.FIXED))
           .val((type === invoice.type.FIXED) ? 1 : null);

      // Update item sum
      let rate = $item.find('.item-rate');
      let qty = $item.find('.item-qty');
      let sum = parseFloat(qty.val()) * rate.val();

      $item.find('.item-sum').val(number_format(sum, ...numberFormat));
      $item.find('.item-raw').val(sum);

      updateTotal();
    });

    invoice.item.qty.on("keyup change", function (e) {
      let $item = $(this).closest('.invoice-item');
      let qty = parseInt($(this).val());

      if (!isNaN(qty) && qty !== 0) {
        let rate = $item.find('.item-rate');
        let sum = parseFloat($(this).val()) * parseFloat(rate.val());

        $item.find('.item-sum').val(number_format(sum, ...numberFormat));
        $item.find('.item-raw').val(sum);
      } else {
        $item.find('.item-sum, .item-raw').val(null);
      }
      updateTotal();
    });

    invoice.item.rate.on("keyup change", function (e) {
      let $item = $(this).closest('.invoice-item');
      let rate = parseInt($(this).val());

      if (!isNaN(rate) && rate !== 0) {
        let qty = $item.find('.item-qty');
        let sum = parseFloat(qty.val()) * parseFloat($(this).val());

        $item.find('.item-sum').val(number_format(sum, ...numberFormat));
        $item.find('.item-raw').val(sum);
      } else {
        $item.find('.item-sum, .item-raw').val(null);
      }
      updateTotal();
    });

    invoice.discount.input.on("keyup change", function (e) {
      let discount = number_format(invoice.discount.input.val(), ...numberFormat);
      invoice.discount.value.text(discount)

      if (discount.toString() !== '0,00' && invoice.subtotal.text() !== '0,00') {
        let total = parseFloat(invoice.subtotal.text()) - parseFloat(invoice.discount.input.val());
        invoice.total.text(number_format(total, ...numberFormat));
      } else {
        invoice.total.text(invoice.subtotal.text());
      }
    })

    function updateTotal() {
      let sum = 0;
      invoice.item.raw.each(function() {
        sum += Number($(this).val());
      });

      let total = sum - invoice.discount.input.val();

      invoice.subtotal.text(number_format(sum, ...numberFormat));
      invoice.total.text(number_format(total, ...numberFormat));
    }
  });

  function number_format(number, decimals = 2, dec_point = '.', thousands_sep = ',') {
    let sign = number < 0 ? '-' : '';

    let s_number = Math.abs(parseInt(number = (+number || 0).toFixed(decimals))) + "";
    let len = s_number.length;
    let tchunk = len > 3 ? len % 3 : 0;

    let ch_first = (tchunk ? s_number.substr(0, tchunk) + thousands_sep : '');
    let ch_rest = s_number.substr(tchunk)
                          .replace(/(\d\d\d)(?=\d)/g, '$1' + thousands_sep);
    let ch_last = decimals ?
      dec_point + (Math.abs(number) - s_number)
        .toFixed(decimals)
        .slice(2) :
      '';

    return sign + ch_first + ch_rest + ch_last;
  }
})
