$(document).ready(function () 
{
    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    // set class="protected" to hide r.mouse context menu
    $('.protected').bind('contextmenu', function(e) {
        e.preventDefault();
    });

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
                  $.get('system/templates/yawk-bootstrap3/js/terminate-user.php', function(data) {
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
