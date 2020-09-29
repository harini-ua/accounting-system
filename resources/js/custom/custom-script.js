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
        // label.text(label.text().substr(3))

    } else {
        // label.text(`By ${label.text()}`)
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
        const icon = $(this).find('.collapsible-header').find('i')

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

                to.datepicker({
                    minDate: new Date($(this).val()),
                    format: 'yyyy-mm-dd',
                    changeMonth: true,
                    numberOfMonths: 3,
                    onOpen: datePickerOnOpenModal,
                    onClose: datePickerOnCloseModal
                });
            }),
        to = $("#to").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            numberOfMonths: 3,
            onOpen: datePickerOnOpenModal,
            onClose: datePickerOnCloseModal
        })
            .on("change", function () {
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

function datePickerOnCloseModal() {
    $('.section').addClass('relative')
}
