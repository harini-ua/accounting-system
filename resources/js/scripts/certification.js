jQuery(document).ready(function ($) {
  $('.certification-list-wrapper').each(function () {
    let $this = $(this);

    let form = $this.find("#certification");

    let certification = {
      btn: {
        submit: form.find("button.submit"),
      }
    }

    certification.btn.submit.click(function (e){
      //e.preventDefault();
    })
  });
});