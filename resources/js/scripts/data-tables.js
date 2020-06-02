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

        var $this = $(this);

        swal({
            title: 'Are you sure?',
            text: 'Resource will be deleted!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url      : $(this).data('remove'),
                    type     : 'DELETE',
                    dataType : 'json',
                    data     : { _method: 'DELETE' },
                    success  : function(response) {
                        if (response.success === true) {
                            var dataTable = $('.dataTable').DataTable();
                            var row = $this.parents('tr');

                            if ($(row).hasClass('child')) {
                                dataTable.row($(row).prev('tr')).remove().draw();
                            } else {
                                dataTable.row($(this).parents('tr')).remove().draw();
                            }
                        }
                        swal({
                            title : response.success === false ? 'Error!' : 'Successfully!',
                            text  : response.message,
                            type  : response.success === false ? 'error' : 'success',
                        }).then((value) => {});
                    },
                    error    : function(data) {
                        swal('Error!', 'Resource has not been deleted!', 'error');
                    }
                }).always(function (data) {
                    $('#clients-list-datatable').DataTable().draw(false);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                return false;
            }
        })
    });
})
