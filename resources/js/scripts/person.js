$(document).ready(function() {

    $('.person-list-wrapper').each(function () {
        let $this = $(this);

        $this.find('.tabs .tab a').not('.active').on('click', function () {
            let url = $(this).data('people-href');
            $(location).attr('href', url);
        });
    });

    $('.person-edit-wrapper').each(function () {
        handleSidebar('change-salary-type');
        handleSidebar('change-contract-type');
        handleSidebar('make-former', function(form) {
            $('#back-to-active-button').removeClass('hide');
            clearForm('back-to-active');
        });
        handleSidebar('long-vacation', function(form) {
            $('#back-to-active-button').removeClass('hide');
            clearForm('back-to-active');
        });
        handleSidebar('back-to-active',  function(form) {
            $('#back-to-active-button').addClass('hide');
            $('#long-vacation-button').removeClass('hide');
            clearForm('long-vacation');
            clearForm('make-former');
        });
        handleSidebar('pay-data');
    });

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
          console.log(form);
          const formData = new FormData(form);
          console.log(new FormData(form));
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
                    updateMainForm(form);
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

    function updateMainForm(form)
    {
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
            // update field in view page
            viewUpdate(element, form);
        });
    }

    function clearForm(id)
    {
        const form = document.forms[id];
        if (form) {
            Array.prototype.forEach.call(form.elements, element => {
                if (element.type == 'select-one') {
                    element.value = '';
                    $(element).formSelect();
                } else if (element.type == 'checkbox') {
                    $(element).prop('checked', false);
                    $('[data-checkbox="'+$(element).attr('name')+'"]').addClass('hide');
                } else {
                    element.value = '';
                }
            });
        }
    }

    function viewUpdate(element, form)
    {
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

    function viewFieldUpdate(element, form)
    {
        const field = $('[data-name="'+element.name+'"]');
        if (element.value) {
            let text = element.value;
            if (element.type == 'select-one') {
                text = $(form).find('[value="'+element.value+'"]').text();
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

    function formatCurrency(value, currency)
    {
        const numberFormat = new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: currency,
            currencyDisplay: 'symbol'
        });
        return numberFormat.format(value);
    }
});
