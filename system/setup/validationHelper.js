$(document).ready(function() {  // wait until document is ready
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // RUN AJAX TIMER
    initTimer();

    // set a timeout so that ajax calls will be delayed
    function initTimer(){
        var myTimer = 0;
        $("#installerForm").on('keydown', function() {
            // cancel any previously-set timer
            if (myTimer) {
                clearTimeout(myTimer);
            }

            myTimer = setTimeout(function() {
                // call validation settings
                checkForm();
            }, 200); //delay time in milliseconds
        });
    }

    function checkForm(){
        $('#installerForm').validate({ // initialize the plugin
            errorPlacement: function(error, element) {
                error.insertBefore(element);
            },
            rules: {
                USERNAME: {
                    required: true,
                    minlength: 4,
                    maxlength: 48,
                    remote: {
                        url: "system/plugins/signup/js/check-username.php",
                        type: "post"
                    }
                },
                EMAIL: {
                    required: true,
                    email: true,
                    maxlength: 128
                },
                PASSWORD: {
                    required: true,
                    minlength: 4,
                    maxlength: 48
                },
                PASSWORD2: {
                    required: true,
                    minlength: 4,
                    maxlength: 48,
                    equalTo: "#PASSWORD"
                }
            },
            messages: {
                username: {
                    remote: "Please select another username. &nbsp;"
                },
                PASSWORD2: {
                    equalTo: "Passwords do not match. &nbsp;"
                }
            }
        });
    } // END function check form

}); // END document ready
