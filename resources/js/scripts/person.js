$(document).ready(function() {

    function handleSidebar(id)
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
                },
                error: () => {
                    swal('Error!', 'Please try again later!', 'error');
                }
            });
        });
    }

    function updateMainForm(elements)
    {
        const mainForm = document.forms['main-form'];
        Array.prototype.forEach.call(elements, (element) => {
            const mainFormElement = mainForm.elements[element.name];
            if (mainFormElement) {
                mainForm.elements[element.name].value = element.value;
                if (mainFormElement.type == 'select-one') {
                    $(mainFormElement).formSelect();
                }
            }
        });
    }

    handleSidebar('change-salary-type');
    handleSidebar('change-contract-type');
    handleSidebar('make-former');
    handleSidebar('long-vacation');
});
