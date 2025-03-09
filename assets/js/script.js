(function ($) {
  "use strict";
  
  $(document).ready(function () {
    // Available themes
    const themes = ["pink", "orange", "blue", "green"];
  
    // Load the theme from localStorage and apply it
    const storedTheme = localStorage.getItem("theme") || "pink";
    $("html").attr("data-bs-theme", storedTheme);
  
    // Function to change theme
    function changeTheme(theme) {
      if (themes.includes(theme)) {
        $("html").attr("data-bs-theme", theme);
        localStorage.setItem("theme", theme);
      }
    }
  
    // Event listener for theme buttons
    $(".theme-btn").on("click", function () {
      const selectedTheme = $(this).attr("data-theme");
      changeTheme(selectedTheme);
    });
  });
  
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
  // Magnific popup Video js
  $(document).ready(function () {
    $(".popup-youtube").magnificPopup({
      disableOn: 200,
      type: "iframe",
      mainClass: "mfp-fade",
      removalDelay: 160,
      preloader: false,

      fixedContentPos: false,
    });
  });
  

})(jQuery);
