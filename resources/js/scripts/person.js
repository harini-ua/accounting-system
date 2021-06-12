$(document).ready(function () {

    $('.close-slide-down').on('click', function () {
        $('.slide-down-trigger').removeClass('isOpen')
        $('.slide-down-block').slideUp('fast')
    })

    $('.person-list-wrapper').each(function () {
        let $this = $(this);

        $this.find('.tabs .tab a').not('.active').on('click', function () {
            let url = $(this).data('people-href');
            $(location).attr('href', url);
        });
    });

    const submitCallbacks = {
        'make-former': _ => {
            $('#back-to-active-button').removeClass('hide');
            clearForm('back-to-active');
        },
        'long-vacation': _ => {
            $('#back-to-active-button').removeClass('hide');
            clearForm('back-to-active');
        },
        'back-to-active': _ => {
            $('#back-to-active-button').addClass('hide');
            $('#long-vacation-button').removeClass('hide');
            clearForm('long-vacation');
            clearForm('make-former');
        }
    }

    $('.slide-down-trigger').click(function () {
        let slideDown = $(`#${$(this).attr('data-bind-block')}`),
            animationSpeed = $('.slide-down-trigger.isOpen').length ? 1 : 'fast';
        if (!$(this).hasClass('isOpen')) {
            $('.slide-down-trigger.isOpen')
            $('.slide-down-trigger').removeClass('isOpen')
            $(this).addClass('isOpen')
            $('.slide-down-block').slideUp(1)
            slideDown.slideDown(animationSpeed);
        }
    });

    function enableFormBrn(form) {
        const formData = new FormData(form.get(0)),
            condition =  _ => [...formData.values()].some(el => el.split(' ').join('').length > 0)
        formData.delete('_token');
        if (condition()) {
            form.find('.person-submit-btn').prop('disabled', false)
        } else  {
            form.find('.person-submit-btn').prop('disabled', true)
        }
    }

    function hideFormBrn(form) {
        $(form).closest('.slide-down-block').slideUp('fast');
    }

    $('.person-handle-submit')
        .on('input', 'input', function (e) {
            const form = $(this).parents('form');
            enableFormBrn(form)
        })
        .on('change', 'input', function (e) {
            const form = $(this).parents('form');
            enableFormBrn(form)
        })
        .on('change', 'select', function (e) {
            const form = $(this).parents('form');
            enableFormBrn(form)
        })
        .on('click', '.person-submit-btn', (e) => {
            const form = $(e.target).parents('form').get(0),
                formId = $(form).attr('name'),
                formData = new FormData(form),
                hasCallback = Object.keys(submitCallbacks).includes(formId)

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: resp => {
                    updateMainForm(form);
                    hideFormBrn(form);
                    hasCallback && submitCallbacks[formId]()
                    location.reload();
                },
                error: resp => {
                    const errors = {...resp.responseJSON.errors}
                    for (let key in errors) {
                        let formField = ($(form).find(`[name = ${key}] `));
                        formField.parents('.input-field').find('.error-span').text(errors[key].join(' '))
                    }
                }
            })
        })

    function handleSidebar(id, callback = null) {
        const sidebar = $('#' + id + '-sidebar');
        $('.contact-compose-sidebar .close-icon').click(function () {
            sidebar.removeClass('show');
        });
        $('#' + id + '-button').click(function () {
            sidebar.addClass('show');
        });
        sidebar.find('button').click(function (e) {
            e.preventDefault()
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
                        title: resp.success === false ? 'Error!' : 'Successfully!',
                        text: resp.message,
                        type: resp.success === false ? 'error' : 'success',
                    });
                    updateMainForm(form);
                    hideFormBrn(form);
                    if (typeof callback === 'function') {
                        callback(form);
                    }
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

    function updateMainForm(form) {
        const mainForm = document.forms['main-form'];
        Array.prototype.forEach.call(form.elements, element => {
            if (mainForm) {
                const mainFormElement = mainForm.elements[element.name];
                if (mainFormElement) {
                    mainForm.elements[element.name].value = element.value;
                    if (mainFormElement.type == 'select-one') {
                        $(mainFormElement).formSelect();
                    }
                }
            }
            viewUpdate(element, form);
        });
    }

    function clearForm(id) {
        const form = document.forms[id];
        if (form) {
            Array.prototype.forEach.call(form.elements, element => {
                if (element.type == 'select-one') {
                    element.value = '';
                    $(element).formSelect();
                } else if (element.type == 'checkbox') {
                    $(element).prop('checked', false);
                    $('[data-checkbox="' + $(element).attr('name') + '"]').addClass('hide');
                } else {
                    element.value = '';
                }
            });
        }
    }

    function viewUpdate(element, form) {
        switch ($(form).attr('name')) {
            case 'long-vacation':
                $('[data-name="long_vacation_finished_at"]').closest('tr').addClass('hide');
                break;
            case 'back-to-active':
                $('[data-name="long_vacation_started_at"]').closest('tr').addClass('hide');
                $('[data-name="long_vacation_reason"]').closest('tr').addClass('hide');
                $('[data-name="long_vacation_compensation_sum"]').closest('tr').addClass('hide');
                $('[data-name="long_vacation_comment"]').closest('tr').addClass('hide');
                $('[data-name="long_vacation_plan_finished_at"]').closest('tr').addClass('hide');
                $('[data-name="quited_at"]').closest('.info-block').addClass('hide');
                break;
            case 'make-former':
                $('[data-name="long_vacation_plan_finished_at"]').closest('.info-block').addClass('hide');
                break;
        }
        viewFieldUpdate(element, form);
    }

    function viewFieldUpdate(element, form) {
        const field = $('[data-name="' + element.name + '"]');
        if (element.value) {
            let text = element.value;
            if (element.type == 'select-one') {
                text = $(form).find('[value="' + element.value + '"]').text();
            }
            if (field.attr('data-currency')) {
                text = formatCurrency(text, field.attr('data-currency'))
            }
            field.text(text);
            field.closest('tr').removeClass('hide');
            field.closest('.info-block').removeClass('hide');
        } else {
            field.closest('tr').addClass('hide');
        }
    }

    function formatCurrency(value, currency) {
        const numberFormat = new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: currency,
            currencyDisplay: 'symbol'
        });
        return numberFormat.format(value);
    }
});
