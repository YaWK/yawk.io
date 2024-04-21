$(document).ready(function() {
    // GET / SET CORRECT STATE OF COLLAPSABLE BOXES
    // this requires collapsable boxes to have a unique id in order to save their state
    // Check if localStorage is available
    if (typeof(Storage) === "undefined") {
        // Sorry! No Web Storage support..
        console.warn("Sorry! No Web Storage support... - Collapsable boxes state won't be saved.");
    }
    else {
        // Web Storage is available
        // console.log("Web Storage is available... - Collapsable boxes state will be saved.");
        $('.btn-box-tool[data-widget="collapse"]').each(function() {
            var $thisButton = $(this);
            var $box = $thisButton.closest('.box');
            var $boxBody = $box.find('.box-body');
            var id = $thisButton.attr('id');
            var state = localStorage.getItem(id);

            // Immediately apply the initial state without animation
            if (state === 'collapsed') {
                $box.addClass('collapsed-box');
                $boxBody.hide();
                $thisButton.find('i').removeClass('fa-minus').addClass('fa-plus');
            } else {
                $box.removeClass('collapsed-box');
                $boxBody.show();
                $thisButton.find('i').removeClass('fa-plus').addClass('fa-minus');
            }

            // Properly toggle visibility based on current state
            $thisButton.off('click').on('click', function() {
                if ($boxBody.is(':visible')) {
                    $boxBody.slideUp();
                    localStorage.setItem(id, 'collapsed');
                    $thisButton.find('i').removeClass('fa-minus').addClass('fa-plus');
                } else {
                    $boxBody.slideDown();
                    localStorage.setItem(id, 'expanded');
                    $thisButton.find('i').removeClass('fa-plus').addClass('fa-minus');
                }
            });
        });
    }


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

    function disableButtons(delay)
    {
        // Disable the buttons
        $('#loginButton').removeClass().addClass('btn btn-success disabled').attr('id', 'LOGIN_FORBIDDEN');
        $('#resetPasswordButton').removeClass().addClass('btn btn-danger disabled');

        // Enable the buttons after the specified delay
        setTimeout(function() {
            $('#LOGIN_FORBIDDEN').attr('id', 'loginButton').removeClass().addClass('btn btn-success');
            $('#resetPasswordButton').removeClass().addClass('btn btn-danger');
        }, delay);
    }

    // submit login form
    $("#loginButton").click(function(){
        if ($('#loginButton').length > 0) {
            // Either #loginButton or #LOGIN_FORBIDDEN element exists
            if ($('#loginButton').hasClass('btn') && $('#loginButton').hasClass('btn-success') && $('#loginButton').hasClass('disabled'))
            {
                // The loginButton has all three classes: btn, btn-success, and disabled
            }
            else {
                // The loginButton is not disabled
                $("#loginForm").submit();
                disableButtons(10000);
            }
        }
        else if ($('#LOGIN_FORBIDDEN').length > 0)
        {
            // Either #loginButton or #LOGIN_FORBIDDEN element exists
            if ($('#LOGIN_FORBIDDEN').hasClass('btn') && $('#LOGIN_FORBIDDEN').hasClass('btn-success') && $('#LOGIN_FORBIDDEN').hasClass('disabled')) {
                // The loginButton has all three classes: btn, btn-success, and disabled
            } else {
                // The loginButton is not disabled
                // $("#loginForm").submit();
            }
        }
    });

    // BLOCKED USER BUTTON (user-edit.php)
    $("#blockedBtn").hover(function()
    {
        $("#blockedBtn").hide();
        $("#askBtn").fadeIn(820);
    });
    // var requestUID = $("#acceptBtn").attr('data-requestUID');//Attribut auslesen und in variable speichern

});