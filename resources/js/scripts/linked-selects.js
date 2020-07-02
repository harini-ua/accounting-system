$(document).ready(function() {

    $('.linked').change(function() {
        $.ajax({
            url: this.dataset.url + '/' + this.value,
            type: "GET",
            success: data => {
                if (data.length) {
                    reloadOptions('[data-linked="'+this.id+'"]', data);
                }
            },
            error: data => console.error('Error:', data)
        });
    });

    const reloadOptions = (selector, options) => {
        $(selector).html('');
        options.forEach(option => {
            $(selector).append('<option value="'+option.id+'">'+option.name+'</option>')
        });
        $(selector).formSelect();
    }

});
