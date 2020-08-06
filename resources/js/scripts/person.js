$(document).ready(function() {

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
                    updateMainForm(form.elements);
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

    function updateMainForm(elements)
    {
        const mainForm = document.forms['main-form'];
        Array.prototype.forEach.call(elements, element => {
            const mainFormElement = mainForm.elements[element.name];
            if (mainFormElement) {
                mainForm.elements[element.name].value = element.value;
                if (mainFormElement.type == 'select-one') {
                    $(mainFormElement).formSelect();
                }
            }
        });
    }

    function clearForm(id)
    {
        const form = document.forms[id];
        if (form) {
            Array.prototype.forEach.call(form.elements, element => {
                element.value = '';
                if (element.type == 'select-one') {
                    $(element).formSelect();
                }
            });
        }
    }

    handleSidebar('change-salary-type');
    handleSidebar('change-contract-type');
    handleSidebar('make-former');
    handleSidebar('long-vacation', function(form) {
        $('#back-to-active-button').removeClass('hide');
        $('#long-vacation-button').addClass('hide');
        clearForm('back-to-active');
    });
    handleSidebar('back-to-active',  function(form) {
        $('#back-to-active-button').addClass('hide');
        $('#long-vacation-button').removeClass('hide');
        clearForm('long-vacation');
    });
});
