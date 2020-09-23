$(document).ready(function () {
  $('.salary-review-list-wrapper').each(function () {
    let $this = $(this);

    //..
  });

  $('.salary-review-create-wrapper, .salary-review-edit-wrapper').each(function () {
    let $this = $(this);

    let reason = $this.find('form select#reason');
    reason.on('change', function () {
      let selected = $(this);
      $('#prof_growth')
        .prop('disabled', (selected.val() !== 'PROFESSIONAL_GROWTH'))
        .closest('.input-field')
        .find('.select-dropdown')
        .prop('disabled', (selected.val() !== 'PROFESSIONAL_GROWTH'))
      ;
    });
  });
});
