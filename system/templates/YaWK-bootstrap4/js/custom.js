/**
 * @file custom.js
 * @brief This file contains all custom javascript functions for the YaWK bootstrap4 template
 * @details this file is loaded after all other javascript files, so you can overwrite any function you like
 * this provides generic methods to set a navbar sticky on scroll, smooth scrolling to any element on the page
 * and a scroll to top button handling. You can add / change / remove any function you like.
 * This gives you the flexibility to customize your template to your needs.
 *
 * If you are not familiar with javascript, you can find a lot of tutorials on the web.
 */
$(document).ready(function()    // all functions are loaded after document is ready
{
    /**
     * @brief fadeInNavbar adds a fadeIn animation to the navbar on page load
     * @details you can change the animation type and speed by changing the class name
     * Take a look at https://daneden.github.io/animate.css/ for a list of all available animations
     */
    // add animated fadeIn class to navbar on page load
    $('#navbar').addClass('animated fadeIn slow'); // if you don't want the animation, remove this line

    /**
     * @brief setSticky makes a navbar sticky on scroll
     * @details this is achieved by adding a fixed-top class to the navbar
     * @param domElement the id of the navbar element
     * @param stickTo the id of the element to stick to
     * @param offset the offset in px to stick to
     */
    function setSticky(domElement, stickTo, offset)
    {   // check if domElement and stickTo are set
        if (domElement) {
            console.log('domElement: '+domElement);
        }
        else {
            console.error('Unable to setSticky - domElement is null or undefined: '+domElement);
            alert('Unable to setSticky - domElement is null or undefined: '+domElement);
        }
        if (!stickTo) {
            console.error('Unable to setSticky - stickTo is null or undefined: '+stickTo);
            alert('Unable to setSticky - stickTo is null or undefined: '+stickTo);
        }

        // check if offset is set, if not, set to 0
        if (!offset) offset = 0;

        // add fixed-top class to navbar on scroll
        $(window).scroll(function()
        {   // if scrolled to top is greater than the current height of intro position
            // this ensures that the navbar is only fixed, if the intro section is scrolled out of view
            if ($(window).scrollTop() > $(stickTo).outerHeight())
            {   // add shadow class to navbar if scrolled to top
                $('#'+domElement).addClass('fixed-top shadow');
                // get height of navbar
                var navbar_height = $('.'+domElement).outerHeight();
                // set padding-top of body to the height of the navbar
                $('body').css('padding-top', navbar_height + 'px');
            }
            else // if scrolled to top is less than the current height of intro position
            {   // = not scrolled to top, then remove fixed-top class from navbar
                $('#'+domElement).removeClass('fixed-top');
                // remove padding top from body to reset to default
                $('body').css('padding-top', 0);
            }
        });
    } // end function setSticky

    // call setSticky function on this elements to make them sticky on scroll:
    // you can add / remove / change them to any element you like
    setSticky('navbar', '#intro', 0);
    setSticky('subMenu', '#intro', 100);

    // smooth scrolling to any element on the page, if it got an anchor link
    // this adds smooth scrolling to the subMenu.
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
                console.log('Info: Velocity.js is not loaded. Please consider loading velocity.js within the template assets if you want the smoothest scroll experience. Error message: ', error.message);
                // scroll to target element
                $('html, body').animate({
                    scrollTop: $(href).offset().top - 250
                }, 2400);
            }
        }
        // handling of non-anchor, external links
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

    /**
     * @brief if enabled, this will set a cookie to remember the user choice of dark or light mode
     * @brief this code sets the cookie for the frontend switch
     */
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

    /**
     * @brief this code will fade out an element on scroll down
     * @details this works well with images, like a carousel on top of the page that fades out on scroll down
     * If you want to use this, add a div with class="scrollDownFadeOut" or add scrollDownFadeOut class to any element.
     */
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

    /**
     * @brief this code will add a tooltip to any element with data-toggle="tooltip"
     * @details this works well with any elemnt that has a title attribute
     */
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /**
     * @brief import image compare viewer
     * @details this will add a before/after image comparison slider to any element with class="image-compare"
     * take a look at the options below to customize the slider
     */
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

    // import single image compare viewer
    // import ImageCompare from "image-compare-viewer";
    // if you just need a single image compare viewer, you can use this code:
    // Get your element
    // const element = document.getElementById("image-compare");
    // const viewer = new ImageCompare(element).mount();

}); // EOF document ready
