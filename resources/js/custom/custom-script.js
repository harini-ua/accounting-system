/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Custom Filters
class Filters
{
    constructor() {
        this.filters = {};
    }
    get(name) {
        return this.filters[name];
    }
    set(name, filter) {
        if (filter) {
            this.filters = Object.assign({}, this.filters, {
                [name]: filter,
            })
        } else {
            delete(this.filters[name]);
        }
    }
    url(route) {
        const url = new URL(route);
        for (let name in this.filters) {
            url.searchParams.set(name, this.filters[name]);
        }
        return url.href;
  }
}

window.filters = window.filters || new Filters();

$('.handle-submit-form').on('submit', function (e) {
  e.preventDefault()
  const form = this,
    formData = new FormData(form),
    url = form.getAttribute('action')
  $(form).find('.error-span').text('')
  $.ajax({
    url,
    type: "POST",
    processData: false,
    contentType: false,
    data: formData,
    success: _ => {
      const table = $('.dataTable');
      table.DataTable().draw(true);
      clearForm(form)
      const dataCreatedItem = $(form).attr('data-created-item')
      Swal.fire(
        'Success!',
        `New ${dataCreatedItem} has been create successful`,
        'success',
      )
    },
    error: response => {
      const errors = {...response.responseJSON.errors}

      for (let key in errors) {
        let formField = ($(form).find(`[name = ${ key }] `));
        formField.parents('.input-field').find('.error-span').text(errors[key].join(' '))
      }

    }
  });

})

function clearForm(form) {
  Array.prototype.forEach.call(form.elements, element => {
    element.classList.contains('valid') && element.classList.remove('valid')
    if (element.type == 'select-one') {
      element.value = '';
      $(element).formSelect();
    } else if (element.type == 'checkbox') {
      $(element).prop('checked', false);
      $('[data-checkbox="' + $(element).attr('name') + '"]').addClass('hide');
    } else {
      let label = document.querySelector(`label[for="${element.id}"]`);
      label && label.classList.contains('active') && label.classList.remove('active');
      element.value = '';
    }
  });
}

$('body').on('click', '.slide-down-btn', function (e) {
  e.preventDefault()
  $(this).parent().find('.slide-down-block').slideDown('fast')
  $(this).hide()
})
$('body').on('click', '.slide-up-btn', function (e) {
  e.preventDefault();
  var slideDownBlock = $(this).parents('.slide-down-block')
  slideDownBlock.slideUp('fast', function () {
      $('.slide-down-btn').show()
      clearForm(slideDownBlock.find('.handle-submit-form').get(0))
      slideDownBlock.find('.error-span').text('')
    }
  )
})



