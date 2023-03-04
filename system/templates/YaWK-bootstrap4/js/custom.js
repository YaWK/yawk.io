$(document).ready(function() {
    $('.scrollup').click(function() {
        $("html, body").animate({scrollTop:0}, 600);
        return false;
    });
    $('#darkMode').click(function() {
        var id = $('#darkMode').data('id');
        document.cookie = 'frontendSwitchID=' + id;
    });
    $('#lightMode').click(function() {
        var id = $('#lightMode').data('id');
        document.cookie = 'frontendSwitchID=' + id;
    });

    $(window).scroll(function() {
        var screenWidth = $(window).width();
        var scrollTop = $(window).scrollTop();
        var fadeOutValue = 1 - (scrollTop / (screenWidth / 3));
        $(".scrollDownFadeOut").css("opacity", fadeOutValue);
    });


    var $scrollingDiv = $("#scrollingDiv");
    $(window).scroll(function() {
        $scrollingDiv.stop().animate({"marginTop": ($(window).scrollTop())}, 0);
    });
    $(".sliding-link").click(function(e) {
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top - 150}, 'slow');
        window.location.hash = aid;
    });


    $('#terminateUser').click(function() {
        var terminate = window.confirm("ACHTUNG!\nDas wird Deinen Account permanent deaktivieren.\n" + "Bist Du Dir sicher, dass Du das tun willst?");
        if (terminate === true) {
            var terminateUser = window.confirm("Bist Du Dir wirklich ganz sicher?\n" + "Diese Aktion kann nicht rueckgaengig gemacht werden.");
            if (terminateUser === true) {
                $.get('system/templates/YaWK-bootstrap3/js/terminate-user.php', function(data) {
                    if (data === "true") {
                        setTimeout("window.location='logout.html'", 0);
                    } else {
                        alert("Fehler: " + data);
                    }
                });
            }
        }
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // import image compare viewer
    // import ImageCompare from "image-compare-viewer";
    // get all image compare elements
    // const viewers = document.querySelectorAll(".image-compare");
    // mount all image compare elements



    //   const element = document.getElementById("image-compare");
    //   const viewer = new ImageCompare(element).mount();
    const options = {
        // UI Theme Defaults
        controlColor: "#FFFFFF",
        controlShadow: true,
        addCircle: true,
        addCircleBlur: true,

        // Label Defaults
        showLabels: true,
        labelOptions: {
            before: 'Vorher',
            after: 'Nachher',
            onHover: true
        },

        // Smoothing

        smoothing: true,
        smoothingAmount: 80,

        // Other options

        hoverStart: true,
        verticalMode: false,
        startingPoint: 50,
        fluidMode: false
    };
    $('.image-compare').each(function() {
        let view = new ImageCompare(this, options).mount();
    });

}); // EOF document ready
