(function ($) {
  "use strict";
  
   /* Odometer Activeate js */
  $(document).ready(function () {
    $(".odometer").appear(function () {
      var odo = $(".odometer");
      odo.each(function () {
        var countNumber = $(this).attr("data-count");
        $(this).html(countNumber);
      });
    });
  });
  
  // // dynamic year for copyright
  // document.getElementById("copyright_year").textContent =
  //   new Date().getFullYear();

  // data background image js
  $("[data-background]").each(function () {
    $(this).css(
      "background-image",
      "url(" + $(this).attr("data-background") + ")"
    );
  });

  

  // Magnific popup image js
  $(".image-popup").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  

})(jQuery);
