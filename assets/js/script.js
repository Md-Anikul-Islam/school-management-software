(function ($) {
  "use strict";
   
  
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
