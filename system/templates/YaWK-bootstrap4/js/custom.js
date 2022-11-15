$(document).ready(function ()
{
    // SMOOTH SCROLL TO TOP
    // to activate smooth scroll from bottom to top SET class="scrollup" on the element you wish to send you upwards
    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    // Frontend Switch (dark / light mode)
    // store ID within localstorage to reduce database calls on page load
    $('#darkMode').click(function(){
        var id = $('#darkMode').data('id');
        document.cookie='frontendSwitchID='+id;
    });
    $('#lightMode').click(function(){
        var id = $('#lightMode').data('id');
        document.cookie='frontendSwitchID='+id;
    });


    // FADE OUT ANY ELEMENT ON SCROLL DOWN
    // If you want to fade out an element on scroll down, set class="scrollDownFadeOut"
    $(window).scroll(function() {
        $(".scrollDownFadeOut").css("opacity", 1 - $(window).scrollTop() / 1400);
    });

    // KEEP DIV IN VIEWPORT
    // to keep any div box in the viewport after scrolling down, set class="scrollingDiv"
    var $scrollingDiv = $("#scrollingDiv");
    $(window).scroll(function(){
        $scrollingDiv
            .stop()
            .animate({"marginTop": ($(window).scrollTop() )}, 0);
    });

    // SMOOTH SCROLL TO ANCHORS
    // if you want your internal links to smooth scroll, set class="sliding-link" target must be a div with id="yourtag"
    $(".sliding-link").click(function(e) {
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top - 150},'slow');
        window.location.hash = aid;
    });

    // set class="protected" to hide r.mouse context menu
    /*
    $("a[href^=#]").on('click', function(event) { 
    event.preventDefault(); 
    var name = $(this).attr('href'); 
    var target = $('a[name="' + name.substring(1) + '"]'); 
    $('html,body').animate({ scrollTop: $(target).offset().top }, 'slow'); 
	});
    */

    // auto adjust menu padding-top
    $(document.body).css('padding-top', $('#topnavbar').height() - 50);
    $(window).resize(function(){
        $(document.body).css('padding-top', $('#topnavbar').height() - 50);
    });

    // terminate user account button
    $('#terminateUser').click(function(){
        // confirmation dialog 1
        var terminate = window.confirm("ACHTUNG!\nDas wird Deinen Account permanent deaktivieren.\n" +
            "Bist Du Dir sicher, dass Du das tun willst?");
        if (terminate === true){
            // just to be sure - ask the user once again
            var terminateUser = window.confirm("Bist Du Dir wirklich ganz sicher?\n"+
                "Diese Aktion kann nicht rueckgaengig gemacht werden.");
            if (terminateUser === true){
                // the php file who set the user off in db
                $.get('system/templates/YaWK-bootstrap3/js/terminate-user.php', function(data) {
                    if (data === "true"){
                        setTimeout ("window.location='logout.html'", 0);
                        //  alert ("it worked!");
                    }
                    else {
                        alert ("Fehler: "+data);
                    }
                    // alert("Server Returned: " + data); // true if it worked
                });
            }
        }
    });

    // enable bootstrap tooltips globally
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

}); // EOF document ready
