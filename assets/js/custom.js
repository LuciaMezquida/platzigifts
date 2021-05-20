//para que reconozca jQuery...
(function ($) {
  $("#categorias-productos").change(function () {
    $ajax({
      url:,
      method: 'POST',
      data:
    })
  });
})(jQuery);
