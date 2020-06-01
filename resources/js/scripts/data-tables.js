/*
 * DataTables - Tables
 */

// Datatable click on select issue fix
$(window).on('load', function () {
  $(".dropdown-content.select-dropdown li").on("click", function () {
    var that = this;
    setTimeout(function () {
      if ($(that).parent().parent().find('.select-dropdown').hasClass('active')) {
        // $(that).parent().removeClass('active');
        $(that).parent().parent().find('.select-dropdown').removeClass('active');
        $(that).parent().hide();
      }
    }, 100);
  });
});

// Select A Row Function

$(document).ready(function () {

    var checkbox = $('#multi-select tbody tr th input');
    var selectAll = $('#multi-select .select-all');

    checkbox.on('click', function () {
    $(this).parent().parent().parent().toggleClass('selected');
    })

    checkbox.on('click', function () {
    if ($(this).attr("checked")) {
      $(this).attr('checked', false);
    } else {
      $(this).attr('checked', true);
    }
    });


    // Select Every Row

    selectAll.on('click', function () {
    $(this).toggleClass('clicked');
    if (selectAll.hasClass('clicked')) {
      $('#multi-select tbody tr').addClass('selected');
    } else {
      $('#multi-select tbody tr').removeClass('selected');
    }

    if ($('#multi-select tbody tr').hasClass('selected')) {
      checkbox.prop('checked', true);

    } else {
      checkbox.prop('checked', false);

    }
    });

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
})
