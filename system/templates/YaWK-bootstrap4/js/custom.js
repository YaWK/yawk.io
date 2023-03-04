$(document).ready(function()
{
    // scroll to top method
    // if you want to use this, add a div with class="scrollup" to your html element
    $('.scrollup').click(function() {
        // this will smooth scroll to top of page
        $("html, body").animate({scrollTop:0}, 600);
        return false;
    });

    // switch between dark and light mode
    // set cookie to remember user choice
    $('#darkMode').click(function() {
        var id = $('#darkMode').data('id');
        document.cookie = 'frontendSwitchID=' + id;
    });
    // on click of an element with id="lightMode", set cookie to remember user choice
    $('#lightMode').click(function() {
        var id = $('#lightMode').data('id');
        document.cookie = 'frontendSwitchID=' + id;
    });

    // this fades out an element on scroll down
    // this works well with images, like a carousel on top of the page that fades out on scroll down
    // if you want to use this, add a div with class="scrollDownFadeOut" or add scrollDownFadeOut class to any element.
    $(window).scroll(function() {
        var screenWidth = $(window).width();
        var scrollTop = $(window).scrollTop();
        var fadeOutValue = 1 - (scrollTop / (screenWidth / 3));
        $(".scrollDownFadeOut").css("opacity", fadeOutValue);
    });

    // this will make a div sticky on scroll
    var $scrollingDiv = $("#scrollingDiv");
    $(window).scroll(function() {
        $scrollingDiv.stop().animate({"marginTop": ($(window).scrollTop())}, 0);
    });
    // this will add smooth scrolling to all anchor links with class="sliding-link"
    $(".sliding-link").click(function(e) {
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top - 150}, 'slow');
        window.location.hash = aid;
    });

    // terminate user account (this must be refactored and moved to yawk's backend core js file)
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

    // add bootstrap tooltip to all elements with data-toggle="tooltip"
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    // import single image compare viewer
    // import ImageCompare from "image-compare-viewer";
    // Get the element
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
            before: 'Before',
            after: 'After',
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
    // on each element with class="image-compare", create a new image compare viewer
    $('.image-compare').each(function() {
        let view = new ImageCompare(this, options).mount();
    });

}); // EOF document ready
