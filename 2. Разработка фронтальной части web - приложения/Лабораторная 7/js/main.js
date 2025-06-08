$(document).ready(function () {

  $(".menu-trigger").on("mouseenter", function () {
    //$(".submenu").addClass("active");
    $(".submenu").fadeIn(300);

    $(".menu").on("mouseleave", function () {
      //$(".submenu").removeClass("active");
      $(".submenu").fadeOut(300);
    })


  })

  $(document).on("contextmenu", function () {
    return false;
  })

  $(document).on("mousedown", function (event) {
    if (event.which == 3) {
      $("#context").css({
        top: event.pageY,
        left: event.pageX,
      })
      $("#context").fadeIn();
      return false;
    }
    $("#context").fadeOut();
  })

})
