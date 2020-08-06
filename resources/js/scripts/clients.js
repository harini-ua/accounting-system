// PLACE HERE CLIENT PAGE JS CODES AND IF NEEDED.
$(document).ready(function () {
  $('.clients-wrapper').each(function() {
    var $this = $(this);

    $('#phone').formatter({
      'pattern': '({{999}}) {{999}}-{{9999}}',
      'persistent': true
    });
  })
});
