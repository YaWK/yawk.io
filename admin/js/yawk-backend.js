$(document).ready(function() {

    // NOTIFICATION DISMISS BTN
    $("#dismiss").click(function()
    {   // fade away the orange label on top
        $("#bell-label").fadeOut();
    });

    // BLOCKED USER BUTTON (user-edit.php)
    $("#blockedBtn").hover(function()
    {
        $("#blockedBtn").hide();
        $("#askBtn").fadeIn(820);
    });
    // var requestUID = $("#acceptBtn").attr('data-requestUID');//Attribut auslesen und in variable speichern


    /*
    RE-LOGIN TIMER
    MOVE THAT TO .....checklogin somewhere to avoid errors, fired on every other page
    var count=6;
    var counter=setInterval(timer, 1000); // 1000 will  run it every 1 second
    function timer()
    {
        count=count-1;
        if (count <= 0)
        {
            timer = '#timer';
            clearInterval(counter);
            //counter ended, do something here
            $(timer).empty();
            $(timer).append("a few").fadeIn();
            return null;
        }
        //Do code for showing the number of seconds here
        document.getElementById("timer").innerHTML=count; // watch for spelling
    }
    */
});