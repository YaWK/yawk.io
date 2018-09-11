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
        // console.log('check form called');
        // initialize form validation plugin
        $('#loginForm').validate({
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
        var	loginboxGreetingTextType = $('#loginboxGreetingTextType').val();
        var	loginboxGreetingTextClass = $('#loginboxGreetingTextClass').val();
        var	loginboxGreetingSubtext = $('#loginboxGreetingSubtext').val();
        var	loginboxGreetingShowName = $('#loginboxGreetingShowName').val();
        var	loginboxLogoutBtnText = $('#loginboxLogoutBtnText').val();
        var	loginboxLogoutBtnClass = $('#loginboxLogoutBtnClass').val();
        var	loginboxRedirect = $('#loginboxRedirect').val();
        var	loginboxRedirectTime = $('#loginboxRedirectTime').val();

        // the logout button
        var logoutBtn = '<a href="logout" id="logoutBtn" class="'+loginboxLogoutBtnClass+'" target="_self">'+loginboxLogoutBtnText+'</a>';

        // shake form function
        function shakeForm()
        {   // if user/pass is wrong or not set pay attention with this animation
            $(loginForm).effect( "shake", {times:3}, 820 );
        }
        // if password or user is not set
        if (!password.trim() || (!user.trim())) {
            // shake the form elements to get users attention
            shakeForm();
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
            // set async to false if you experience double calls
            async: true,
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
                            // console.log('login true');
                            // hide login form
                            $("#heading").hide();
                            $("#loginForm").hide();

                            // check if redirect url is set
                            if (loginboxRedirect)
                            {   // check if redirect time is set
                                if (loginboxRedirectTime)
                                {   // use delay before redirecting
                                    setTimeout(function () {
                                        window.location.href = ""+loginboxRedirect+"";
                                    }, loginboxRedirectTime);
                                }
                                else
                                    {   // redirect instant w/o delay
                                        window.location.replace(""+loginboxRedirect+"");
                                    }
                            }

                            // if greeting text type is set to globaltext
                            if (loginboxGreetingTextType === "GLOBALTEXT")
                            {   // use html paragraph
                                loginboxGreetingTextType = 'p';
                            }

                            // only add class if it is not empty
                            if (loginboxGreetingTextClass)
                            {   // set text class markup
                                var loginboxGreetingTextClassMarkup = ' class="'+loginboxGreetingTextClass+'"';
                            }
                            else
                                {   // no markup needed
                                    loginboxGreetingTextClassMarkup = '';
                                }

                            // maximum greeting
                            if (loginboxGreeting === "greeting-max")
                            {   // do a personal greeting with username
                                $("#thankYouMessage").append('<'+loginboxGreetingTextType+''+loginboxGreetingTextClassMarkup+'>'+loginboxGreetingText+' '+user+' <small>'+loginboxGreetingSubtext+'</small></'+loginboxGreetingTextType+'>'+logoutBtn+'');
                            }

                            // minimal greeting
                            if (loginboxGreeting === "greeting-min")
                            {
                                // welcome message without name
                                $("#thankYouMessage").append('<'+loginboxGreetingTextType+''+loginboxGreetingTextClassMarkup+'>'+loginboxGreetingText+' <small>'+loginboxGreetingSubtext+'</small></'+loginboxGreetingTextType+'>'+logoutBtn+'');
                            }

                            // no greeting, just a logout button
                            if (loginboxGreeting === "greeting-button")
                            {
                                // display logout button
                                $("#thankYouMessage").append(''+logoutBtn+'');
                            }

                            // no greeting, silent login mode
                            if (loginboxGreeting === "greeting-none")
                            {
                                // no welcome message
                                $("#thankYouMessage").hide();
                            }
                        }
                        else
                            {   // login failed
                                // shake form
                                shakeForm();
                                // write failed state to console
                                // console.log('login failed');
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