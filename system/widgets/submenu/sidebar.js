/**
 * @file system/widgets/submenu/sidebar.js
 * @brief Javascript for the Submenu module.
 * @details The $(window).scroll() function is used to detect when the user has scrolled beyond startPosition,
 * at which point the openBtn and mySidebar elements are faded in using .fadeIn(). If the user scrolls back up,
 * the elements are faded out
 *
 * The introBottom and sidebarBottom variables are set to the bottom position of the intro and sidebar elements
 * respectively, and are used to determine if mySidebar should be hidden because it overlaps with intro. If
 * introBottom is greater than or equal to sidebarBottom, the opacity and width of mySidebar are set to 0.
 *
 * this code will should only be executed, if the submenu property 'sidebar' is set to true
 *
 */
function openNav() {
    document.getElementById("mySidebar").style.width = "300px"; // how many pixels wide the sidebar is
    document.getElementById("main").style.marginLeft = "125px"; // how many pixels will the main content be pushed to the right

}
function closeNav() {
    document.getElementById("mySidebar").style.width = "0"; // set width to zero to hide the sidebar
    document.getElementById("main").style.marginLeft= "0"; // reset margin to zero to push main content back to the left
}

$(document).ready(function()
{
    var sidebarOpen = false;                    // is the sidebar open?
    const openBtn = $('#openSubmenuBtn');        // button to open the sidebar
    const sidebar = $('#mySidebar');             // sidebar div box element (defined in submenu widget class)
    var showOpenBtnPositionThreshold = 600;      // position from where the 'open sidebar btn' gets shown (in pixels)
    // - above this position the button will be hidden. This ensures, it will not be interfering with the global menu
    // or any other element on top of page (eg. a carousel or header image) - if this is not wanted, set this value to 0

    // check if openBtn has been clicked
    openBtn.click(function()
    {   // if clicked, open the sidebar
        if (sidebarOpen) {
            closeNav();
        }
        if (!sidebarOpen) {
            openNav();
        }
    });

    // Initially hide the button
    openBtn.hide();     // hide the button on page load

    // which element should be used to determine, if the sidebar should be hidden, because it overlaps with another element?
    var overlapPositionOrDivBox = $('#globalmenu'); // use globalmenu as overlap indicator to hide sidebar

    // Get the current scroll position
    $(window).scroll(function()
    {   // get position of overlap element
        var overlapPosition = overlapPositionOrDivBox.offset().top + overlapPositionOrDivBox.outerHeight();
        // get the bottom position of the sidebar element
        var sidebarCollider = sidebar.offset().top + sidebar.outerHeight();
        // store the sidebar element in a variable
        var thisSidebar = document.getElementById("mySidebar");

        // if the sidebar overlaps with the overlap element, hide the sidebar
        if (overlapPosition >= sidebarCollider) {
            // thisSidebar.style.opacity="0";
            thisSidebar.style.width="0px";
        }

        // Get the current scroll position
        let scrollPosition = $(window).scrollTop();

        // If the user has scrolled beyond threshold, fadeIn the button
        if (scrollPosition >= showOpenBtnPositionThreshold) {
            openBtn.fadeIn();
        }
        else
        {   // user has scrolled back up, so fadeOut button + sidebar
            closeNav();
            openBtn.fadeOut();
        }
    });
});