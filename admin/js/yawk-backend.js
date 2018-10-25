$(document).ready(function() {

    //  modal dialog data-confirm
    $('a[data-confirm]').click(function(ev) {
        modal = '#dataConfirmModal';
        var href = $(this).attr('href');
        var title = $(this).attr('title');
        var icon = $(this).attr('data-icon');
        if (!icon)
        {
            icon = 'fa fa-trash-o';
        }

        if (!$(modal).length) {
            $('body').append('<div id="dataConfirmModal" class="modal fade" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><br><div class="col-md-1"><h3 class="modal-title"><i class="'+icon+'"></i></h3></div><div class="col-md-11"><h3 class="modal-title" id="dataConfirmLabel">'+title+'</h3></div></h3></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Abbrechen</button><a type="button" class="btn btn-danger" id="dataConfirmOK"> <i class="'+icon+'"></i> L&ouml;schen</a></div></div></div></div>');
        }
        $(modal).find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $(modal).modal({show:true});
        return false;
    });

    function dismissNotifications() {
        $.ajax({    // do ajax request
            url: 'js/dismiss-notifications.php',
            type: 'POST',
            success: function (data) {
                if (!data) {
                    alert('Something went wrong!');
                    return false;
                }
            }
        });
        // fade away the orange label on top
        $("#bell-label").fadeOut();
        $('#notification-header').html('You have 0 notifications');
        $('#notification-menu').fadeOut();
    }

    // NOTIFICATION DISMISS BTN
    $("#dismiss").click(function()
    {   // get uid from data value
        // var uid = $(this).attr('data-uid');
        dismissNotifications();
    });


    // BLOCKED USER BUTTON (user-edit.php)
    $("#blockedBtn").hover(function()
    {
        $("#blockedBtn").hide();
        $("#askBtn").fadeIn(820);
    });
    // var requestUID = $("#acceptBtn").attr('data-requestUID');//Attribut auslesen und in variable speichern

});