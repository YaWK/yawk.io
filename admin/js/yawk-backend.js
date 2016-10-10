$(document).ready(function() {

    /* modal dialog data-confirm */
    $('a[data-confirm]').click(function(ev) {
        modal = '#dataConfirmModal';
        var href = $(this).attr('href');
        if (!$(modal).length) {
            $('body').append('<div id="dataConfirmModal" class="modal fade" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><h3 id="dataConfirmLabel"><i style="color:#f0ad4e;" class="fa fa-warning"></i> Achtung! <small>Bist Du sicher?</small></h3></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Abbrechen</button><a type="button" class="btn btn-danger" id="dataConfirmOK"> <i class="fa fa-trash-o"></i> L&ouml;schen</a></div></div></div></div>');
        }
        $(modal).find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $(modal).modal({show:true});
        return false;
    });

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