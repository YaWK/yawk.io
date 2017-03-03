$(document).ready(function () {
    // logout menu animation: on mousemover spinning cog
    $('#logoutMenu').mouseover(function() {
        $('#cog').addClass('fa fa-cog fa-spin');
    });
    // logoutmenu animation: on mouseout still cog
    $('#logoutMenu').mouseout(function() {
        $('#cog').removeClass('fa fa-cog fa-spin');
        $('#cog').addClass('fa fa-cog');
    });

    // body class FX
    $('#bodyFX').fadeIn(920);

    // set class="protected" to hide r.mouse context menu
    $('.protected').bind('contextmenu', function(e) {
        e.preventDefault();
    });

    // auto adjust menu padding-top
    $(document.body).css('padding-top', $('#topnavbar').height() - 50);
    $(window).resize(function(){
        $(document.body).css('padding-top', $('#topnavbar').height() - 50);
    });


    $('.list-group-item').mouseenter(function(){
        $(this).animate({
            backgroundColor: '#4b484b'
        }, 220);
    }).mouseleave(function(){
        $(this).animate({
            backgroundColor: '#383638'
        }, 140);
    });

    // terminate user account button
    $('#terminateUser').click(function(){
        // confirmation dialog 1
        var terminate = window.confirm("ACHTUNG!\nDas wird Deinen Account permanent deaktivieren.\n" +
            "Bist Du Dir sicher, dass Du das tun willst?");
        if (terminate == true){
            // just to be sure - ask the user once again
            var terminateUser = window.confirm("Bist Du Dir wirklich ganz sicher?\n"+
            "Diese Aktion kann nicht rueckgaengig gemacht werden.");
            if (terminateUser == true){
                // the php file who set the user off in db
                  $.get('system/templates/yawk-bootstrap3/js/terminate-user.php', function(data) {
                   if (data == "true"){
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

    // VIDEO.JS HOTKEYS
    // video-js.js is loaded @ startup in welcome.php
    // this is neccesary to avoid obj videojs not found errors
    if (typeof videojs == 'function'){
    // select only if videojs function exists
        $('#01-womanizer').ready(function() { // if loaded
            // unleash hotkeys
            videojs('01-womanizer').hotkeys({
                volumeStep: 0.1,
                seekStep: 5,
                enableMute: true,
                enableFullscreen: true,
                enableVolumeScroll: true,
                // Enhance existing simple hotkey with a complex hotkey
                fullscreenKey: function(e) {
                    // fullscreen with the F key or Ctrl+Enter
                    return ((e.which === 70) || (e.ctrlKey && e.which === 13));
                } // end custom hotkey
            }); // end videojs hotkeys
        }); // end video selector
    } // end if videojs == function


// Wait for window load
    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });

}); // EOF document ready
