(function($) {
    "use strict"; // Start of use strict

    // Closes responsive menu when a scroll trigger link is clicked
    $('.js-scroll-trigger').click(function() {
        $('.navbar-collapse').collapse('hide');
    });

    // Collapse Navbar
    var navbarCollapse = function() {
        if ($("#mainNav").offset().top > 100) {
            $("#mainNav").addClass("navbar-shrink");
            $("#userNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
            $("#userNav").removeClass("navbar-shrink");
        }
    };
    // Collapse now if page is not at top
    navbarCollapse();
    // Collapse the navbar when page is scrolled
    $(window).scroll(navbarCollapse);

    var setHeader = function() {
        $("header.masthead").height($(window).height());
    }
    var footerFixed = false;
    var setFooter = function() {
        var bHeight = $("body").height();
        var wHeight = $(window).height();
        if (wHeight > bHeight) {
            if (!footerFixed) {
                $("body").addClass('sticky-footer');
                footerFixed = true;
            }
        } else {
            if (footerFixed) {
                $("body").removeClass('sticky-footer');
                footerFixed = false;
            }
        }
    }

    $( window ).resize(function() {
        setHeader();
        setFooter();
    });
    setHeader();
    setFooter();

})(jQuery); // End of use strict
