$(document).ready(function () {

    $('.dataTable').on('click', '.delete-link', function(e) {
        e.preventDefault();
        let url = this.href;
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        $.ajax({
            url: url,
            type: "POST",
            data: {_method: 'delete', _token: token},
            success: function(data) {
                window.location.reload();
            },
            error: function(data) {
                console.error('Error:', data);
            }
        });
    });

});
