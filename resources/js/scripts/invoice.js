$(document).ready(function () {
  /* Invoice edit and create */
  /* ------------*/

  /* form repeater jquery */
  var uniqueId = 1;
  if ($(".invoice-item-repeater").length) {
    $(".invoice-item-repeater").repeater({
      show: function () {
        /* Assign unique id to new dropdown */
        $(this).find(".dropdown-button").attr("data-target", "dropdown-discount" + uniqueId + "");
        $(this).find(".dropdown-content").attr("id", "dropdown-discount" + uniqueId + "");
        uniqueId++;
        /* showing the new repeater */
        $(this).slideDown();
      },
      hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
      }
    });
  }

  /* on product change also change product description */
  $(document).on("change", ".invoice-item-select", function (e) {

  });

  /* Initialize Dropdown */
  $('.dropdown-button').dropdown({
    constrainWidth: false, // Does not change width of dropdown to that of the activator
    closeOnClick: false
  });
  $(document).on("click", ".invoice-repeat-btn", function (e) {
    /* Dynamically added dropdown initialization */
    $('.dropdown-button').dropdown({
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      closeOnClick: false
    });
  })

  if ($(".invoice-print").length > 0) {
    $(".invoice-print").on("click", function () {
      window.print();
    })
  }
})
