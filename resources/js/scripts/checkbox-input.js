$(document).ready(function() {
    $('.checkbox-input [type="checkbox"]').change(function() {
        const input = $('[data-checkbox="'+$(this).attr('name')+'"]');
        if ($(this).prop('checked')) {
            input.removeClass('hide');
        } else {
            input.addClass('hide');
        }
    });
});
