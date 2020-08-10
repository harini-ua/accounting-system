$(document).ready(function () {
  /* Invoice edit and create */
  /* ------------*/

  /* form repeater jquery */
  var uniqueId = 1;
  if ($(".invoice-item-repeater").length) {
    $(".invoice-item-repeater").repeater({
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

  /* on product change also change product description */
  $(document).on("change", ".invoice-item-select", function (e) {

  });

  /* Initialize Dropdown */
  $('.dropdown-button').dropdown({
    constrainWidth: false, // Does not change width of dropdown to that of the activator
    closeOnClick: false
  });
  $(document).on("click", ".invoice-repeat-btn", function (e) {
    /* Dynamically added dropdown initialization */
    $('.dropdown-button').dropdown({
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      closeOnClick: false
    });
  })

  if ($(".invoice-print").length > 0) {
    $(".invoice-print").on("click", function () {
      window.print();
    })
  }

  //var elementPosition = $('#action').offset();
  //
  //$(window).scroll(function(){
  //  if($(window).scrollTop() > elementPosition.top - 65){
  //    $('#action').css('position','fixed').css('top', '65px').css('right', 0);
  //  } else {
  //    $('#action').css('position','static').css('top', '65px').css('right', 0);
  //  }
  //});

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

  function updateViewInvoice(elements)
  {
    Array.prototype.forEach.call(elements, element => {
      if (element.name === 'fee') {
        $invoicePaidValue = $('.invoice-paid-value.currency .value');
        $paidToDate = $invoicePaidValue.text().replace(/,/g, '.');
        $paidToDate = parseFloat($paidToDate) + parseFloat(element.value);
        $paidToDate = number_format($paidToDate,2, ',', ' ');
        $invoicePaidValue.text($paidToDate);
      }
    });
  }

  handleSidebar('payment', function(form) {
    //
  });

  function number_format( number, decimals = 0, dec_point = '.', thousands_sep = ',' ) {

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
