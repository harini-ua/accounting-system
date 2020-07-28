$(document).ready(function() {

    function handleSidebar(id)
    {
        $('.contact-compose-sidebar .close-icon').click(function() {
            $('#'+id+'-sidebar').removeClass('show');
        });

        $('#'+id+'-button').click(function() {
            $('#'+id+'-sidebar').addClass('show');
        });

    }

    handleSidebar('change-salary-type');
});
