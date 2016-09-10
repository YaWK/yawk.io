/* signUp Check JS
 * ask a question and show registration form
 * or send user to contact form otherwise
 *
  * */
$(document).ready(function () {
    // first of all, hide the reg form
    $("#form").hide();
    // hide the alternative too
    $("#alt").hide();
    // if user answers question with yes
    $( "#yes" ).css('cursor', 'pointer').click(function() {
        // hide question
        $("#adultCheck").fadeOut(420);
        // show the registration form
        $("#form").delay(420).fadeIn(1240);
    });
    // if user answers question with no
    $( "#no" ).css('cursor', 'pointer').click(function() {
        // hide question
        $("#adultCheck").fadeOut(420);
        // hide form - just to be sure
        $("#form").fadeOut(420);
        // show alternative
        $("#alt").delay(420).fadeIn(1240);
    });
    // if user clicked on further contact
    $("#contact").css('cursor', 'pointer').click(function () {
       // send him to contact page
        window.location.replace("index.html");
        // window.location.replace("http://www.goodconnect.net");
    });
    // if user is not interestet, send him to index page
    $("#home").css('cursor', 'pointer').click(function () {
        // send him to home page
        window.location.replace("index.html");
        // window.location.replace("http://www.goodconnect.net/");
    });

}); /* end document ready */