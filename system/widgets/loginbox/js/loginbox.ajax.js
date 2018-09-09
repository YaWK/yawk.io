$(document).ready(function(){
    // RUN AJAX TIMER
    initTimer();
    // set a timeout so that ajax calls will be delayed
    function initTimer(){
        var myTimer = 0;
        $("#loginForm").on('keydown', function() {
            // cancel any previously-set timer
            if (myTimer) {
                clearTimeout(myTimer);
            }
            // set timeout function
            myTimer = setTimeout(function() {
            // call validation settings
                checkForm();
            }, 300); //delay time in milliseconds
            });
    }

    // check form function
    function checkForm(){
        console.log('check form called');

        $('#loginForm').validate({ // initialize the plugin
            // set placement of error messages
            errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        rules: {
        user: {
            required: true,
            minlength: 4,
            maxlength: 48
            },
        password: {
            required: true,
            minlength: 4,
            maxlength: 48
            }
        }
        });
    }

    var loginForm = $("#loginForm");

    // send the form when enter is pressed
    $(loginForm).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode === '13'){
            // invoke submit
            $('#submit').click();
        }
    });

    // on submit
    $(loginForm).submit(function(e)
    {   //
        e.preventDefault();
        // get username value from form
        var	user =	$('#user').val();
        // get password from form
        var	password = $('#password').val();
        // get greeting from form
        var	loginboxGreeting = $('#loginboxGreeting').val();
        var	loginboxGreetingText = $('#loginboxGreetingText').val();
        var	loginboxGreetingSubtext = $('#loginboxGreetingSubtext').val();
        var	loginboxGreetingShowName = $('#loginboxGreetingShowName').val();

        // shake form function
        function shakeForm()
        {   // if user/pass is wrong or not set pay attention with this animation
            $(loginForm).effect( "shake", {times:3}, 820 );
        }
        // if password or user is not set
        if (!password.trim() || (!user.trim())) {
            // shake the form elements to get users attention
            shakeForm();
            // $( "#loginForm" ).effect( "shake", {times:3}, 820 );
            return false;
        }

        // run ajax form
        $.ajax({
            // PHP file to process within this request
            url:'system/widgets/loginbox/js/loginbox.ajax.php',
            // form method (get or post)
            type:'POST',
            // allow cross origin requests
            crossOrigin: true,
            // set async to false to avoid double calls
            async: false,
            // data string
            data: {user: user, password: password},
            // data:'user='+user+'&password='+password,
            // check if request was successful
            success:function(data){
                // if no data is set
                if(!data){
                    // draw error message and return false
                    console.log('ajax error during login: no data was sent');
                    alert('ERROR: ajax processing failed: no data was sent');
                    return false;
                }
                else
                    {   // ajax was succesful, check php return
                        if (data.status === true)
                        {   // login successful
                            console.log('login true');
                            // hide login form
                            $("#heading").hide();
                            $("#loginForm").hide();

                            if (loginboxGreeting === 'true')
                            {
                                if (loginboxGreetingShowName === 'true')
                                {   // personal greeting with username
                                    $("#thankYouMessage").append('<h2 class="animated fadeIn">'+loginboxGreetingText+' '+user+' <small>'+loginboxGreetingSubtext+'</small></h2>');
                                }
                                else
                                    {   // greeting without name
                                        $("#thankYouMessage").append('<h2 class="animated fadeIn">'+loginboxGreetingText+' <small>'+loginboxGreetingSubtext+'</small></h2>');
                                    }
                            }
                        }
                        else
                            {   // login failed
                                // shake form
                                shakeForm();
                                // write failed state to console
                                console.log('login failed');
                            }
                    }
            },
            error:function(data){
                // login failed
                shakeForm();
                console.log('Login failed / username or pwd wrong');
            }
        });
    });
});