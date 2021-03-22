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

/**
 * Roman numeral converter
 *
 * @param num
 * @returns {string|number}
 */
function romanize (num) {
  if (isNaN(num)) return NaN;

  let digits = String(+num).split(""),
    key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM", "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC", "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"],
    roman = "", i = 3;

  while (i--)
    roman = (key[+digits.pop() + (i * 10)] || "") + roman;

  return Array(+digits.join("") + 1).join("M") + roman;
}

/**
 * Set cookie value
 *
 * @param cname
 * @param cvalue
 * @param exdays
 */
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get cookie value
 *
 * @param cname
 * @returns {string}
 */
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

// Custom Filters
class Filters {
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
            delete (this.filters[name]);
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
                let formField = ($(form).find(`[name = ${key}] `));
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

// filters
$('.select-filters').on('change', function (e) {
    const text = $(this).find('option:selected').text()
    const input = $(this).parents('.filter-btn').find('.custom-filter-input')
    const label = input.parents('.filter-btn').find('.custom-filter-label')
    if (text !== 'All') {
        input.val(text).addClass('active')
        label.addClass('active')
        const labelTextToArray = label.text().split(' ')
        const index = labelTextToArray.findIndex(el => el === 'By')
        index >= 0 && labelTextToArray.splice(index, 1)
        label.text(labelTextToArray.join(' '))
    } else {
        const condition = !label.text().split(' ').includes('By')
        condition && label.text(`By ${label.text()}`)
        label.removeClass('active')
        input.val('')
    }
})

$('.custom-filter-trigger').on('click', function (e) {
    const select = $(this).parents('.custom-filter-btn').find('.select-filters')
    select.select2("open");
})
$('.custom-filter-input')
    .each(function (i) {
        $(this).val('')
    })

$('.dropdown-content').on('click', 'a', function (e) {
    var text = $(this).text(),
        inputField = $(this).parents('.input-field'),
        label = inputField.find('.custom-filter-label')
    if (text !== 'All') {
        highLightField(inputField, text)
    } else {
        label.removeClass('active')
        inputField.find('.custom-filter-input').val('').removeClass('active')
    }
})

function highLightField(inputField, text) {
    inputField.find('.custom-filter-label').addClass('active')
    inputField.find('.custom-filter-input').val(text).addClass('active')
}

$(function () {


    $('.collapsible').on('click', 'li', function () {
        const icon = $(this).find('.collapsible-header').find('.collapsible-arrow')

        if ($(this).hasClass('active')) {
            icon.text('arrow_upward')
        } else {
            icon.text('filter_list')
        }
    })

    from = $("#from")
        .datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            numberOfMonths: 3,
            onOpen: datePickerOnOpenModal,
            onClose: datePickerOnCloseModal
        })
        .on("change", function () {
            highlightLabel($(this))
            to.datepicker({
                minDate: new Date($(this).val()),
                format: 'yyyy-mm-dd',
                changeMonth: true,
                numberOfMonths: 3,
                onOpen: datePickerOnOpenModal,
                onClose: datePickerOnCloseModal
            });
        });

    to = $("#to")
        .datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            numberOfMonths: 3,
            onOpen: datePickerOnOpenModal,
            onClose: datePickerOnCloseModal
        })
        .on("change", function () {
            highlightLabel($(this))
            from.datepicker({
                format: 'yyyy-mm-dd',
                changeMonth: true,
                numberOfMonths: 3,
                onOpen: datePickerOnOpenModal,
                onClose: datePickerOnCloseModal,
                maxDate: new Date($(this).val())
            });
        });
})

function datePickerOnOpenModal() {
    $('.section').addClass('modal-is-open')
    $('.section').removeClass('relative')
    $('body').append($(
        '<div>', {
            class: 'modal-overlay is-open',
        })
    )
}
function highlightLabel (input) {
    input.parent()
        .find('.custom-filter-label')
        .addClass('active')
}

function datePickerOnCloseModal() {
    $('.section').addClass('relative')
}


// custom form select

$('.select-trigger').on('click', function () {
    const select = $(this).parents('.input-field').find('.form-select')
    select.select2('open')

})

$('.form-select').on('change', function (e) {
    const defaultValue = $(this).find('.first_default').text()
    const parent = $(this).parents('.input-field')
    const input = parent.find('.select-trigger')
    const label = parent.find('label')
    const bindedSelect = $('#' + $(this).attr('data-binded-select'))

    if ($(this).val() !== defaultValue ) {
        const selectedOptionValue =$(this).find(`option[value = ${$(this).val()}]`).text()
        input.val(selectedOptionValue)
        label.addClass('active')
    } else {
        if(bindedSelect) {
            bindedSelect.parents('.input-field').find('.select-trigger').val('');
            bindedSelect.parents('.input-field').find('label').removeClass('active');
        }
        input.val('')
        label.removeClass('active')
    }
})


$('body').on('change', '.custom-select', function (e) {
    const parent = $(this).parents('.input-field')
    const input = parent.find('.custom-select-input')
    const label = parent.find('label')
    const defaultValue = $(this).find('.first_default').val()
    if ($(this).val() !== defaultValue && $(this).val() !== '' ) {
        const selectedOptionValue =$(this).find(`option[value = ${$(this).val()}]`).text()
        input.val(selectedOptionValue)
        label.addClass('active')
    } else {
        input.val('')
        label.removeClass('active')
    }
})


