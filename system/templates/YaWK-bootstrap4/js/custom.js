$(document).ready(function()
{
    // add animated fadeIn class to navbar on page load
    $('#navbar').addClass('animated fadeIn slow');

    function setSticky(domElement, stickTo, offset)
    {
        if (domElement) {
            console.log('domElement set sticky: '+domElement);
        }
        else {
            console.error('Unable to setSticky - domElement is null or undefined: '+domElement);
            alert('Unable to setSticky - domElement is null or undefined: '+domElement);
        }
        if (!stickTo) {
            console.error('Unable to setSticky - stickTo is null or undefined: '+stickTo);
            alert('Unable to setSticky - stickTo is null or undefined: '+stickTo);
        }
        if (!offset) offset = 0;

        // add fixed-top class to navbar on scroll
        $(window).scroll(function()
        {   // if scrolled to top is greater than the current height of intro position
            // this ensures that the navbar is only fixed, if the intro section is scrolled out of view
            if ($(window).scrollTop() > $(stickTo).outerHeight())
            {
                // add shadow class to navbar if its scrolled to top
                $('#'+domElement).addClass('fixed-top shadow');
                // get height of navbar
                var navbar_height = $('.'+domElement).outerHeight();
                // set padding-top of body to the height of the navbar
                $('body').css('padding-top', navbar_height + 'px');
            }
            else
            {   // if not scrolled to top, remove fixed-top class from navbar
                $('#'+domElement).removeClass('fixed-top');
                // remove padding top from body to reset to default
                $('body').css('padding-top', 0);

            }
        });

    } // end function setSticky
    setSticky('navbar', '#intro', 0);
    setSticky('subMenu', '#intro', 100);


    $('#subMenu li').click(function(e) {
        e.preventDefault();
        // Submenu Smooth scrolling REQUIRES velocity.js as loaded asset for smooth animation
        var linkObject = $(this).find('a');     // get link object
        var href = linkObject.attr('href');     // extract href
        var target = linkObject.attr('target'); // extract target



        // The target starts with a "#" character
        if (href.charAt(0) === '#') {
            try {
                // this will smooth scroll to the target element using velocity
                $('html, body').velocity('scroll', {
                    offset: $(href).offset().top - 250,
                    duration: 2400,
                    easing: 'easeOutQuart'
                });
            }
            catch (error) {
                // velocity.js is not loaded: fallback to jquery animate method
                console.log('Info: Velocity.js is not loaded. Please consider loading velocity.js within the assets if you want the smoothest scroll experience. Error message: ', error.message);
                // scroll to target element
                $('html, body').animate({
                    scrollTop: $(href).offset().top - 250
                }, 2400);
            }
        }
        else
        {   // The link does NOT start with a "#" character (so it must be an external link)
            // let's check if the target is set
            if (target) {
                // target is set, open link with target
                window.open(href, target);
            }
            else
            {   // target is not set, so open link in same window
                window.open(href, '_self');
            }
        }
    });

    // scroll to top method REQUIRES VELOCITY.JS loaded before!
    // if you want to use this, add a div with class="scrollup" to your html element
    $('.scrollup').click(function() {
        try{
            // this will smooth scroll to top of page using velocity
            $("html, body").velocity("scroll", {
                duration: 2400,
                easing: "easeOutExpo"
                //easing: "ease-out"
            });
        }
        catch {
            // velocity.js is not loaded: fallback to jquery animate method
            console.log('Error: Velocity.js is not loaded. Please consider loading velocity.js within the assets if you want the smoothest scroll experience. Error message: ', error.message);
            // scroll to target element

            $("html, body").animate({scrollTop:0}, 1200);
        }
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
