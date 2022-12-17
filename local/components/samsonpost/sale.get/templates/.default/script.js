$(document).on('submit', '.js-sale-get', function(x) {

  let $form = $(this);
  let $button = $('input[type=submit]', $form);
  let $resultBox = $('.js-sale-result-box');

  $.ajax({
    url: '/local/ajax/sale-get.php',
    type: 'post',
    dataType: 'json',
    beforeSend: function () {
      $button.prop('disabled', true);
    }
  }).done(function (res) {

    $button.prop('disabled', false);
    $resultBox.html(res.message);
    $resultBox.removeClass('js-hidden');

  });

  x.preventDefault();

});

$(document).on('submit', '.js-sale-check', function(x) {

  let $form = $(this);
  let $button = $('input[type=submit]', $form);
  let $resultBox = $('.js-sale-check-box');

  $.ajax({
    url: '/local/ajax/sale-check.php',
    type: 'post',
    dataType: 'json',
    data: $form.serialize(),
    beforeSend: function () {
      $button.prop('disabled', true);
    }
  }).done(function (res) {

    $button.prop('disabled', false);
    $resultBox.html(res.message);
    $resultBox.removeClass('js-hidden');

  });

  x.preventDefault();

});