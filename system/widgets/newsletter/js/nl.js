$(document).ready(function(){
    // RUN AJAX TIMER
    initTimer();
    // set a timeout so that ajax calls will be delayed
    function initTimer(){
        var myTimer = 0;
        $("#form").on('keydown', function() {
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
        $('#form').validate({ // initialize the plugin
            // set placement of error messages
            errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        rules: {
        name: {
            required: true,
            minlength: 4,
            maxlength: 48
            },
        email: {
            required: true,
            email: true,
            maxlength: 128
            }
        }
        });
    }

    // on submit
    $('#submit').click(function(){
        // get email value from form
        var	email =	$('#email').val();
        // get name from form
        var	name =	$('#name').val();
        // if no email is set
        if (!email.trim()) {
        //    alert('Please insert your email!');
            // shake the form elements to get users attention
            $( "#form" ).effect( "shake", {times:3}, 820 );
            return false;
        }
        else
            {   // run form validator
                checkForm();
            }

        // run ajax form
        $.ajax({
            // PHP file to process within this request
            url:'system/widgets/newsletter/js/nl.php',
            // form method (get or post)
            type:'post',
            // allow cross origin requests
            crossOrigin: true,
            // data string
            data:'name='+name+'&email='+email,
            // check if request was successful
            success:function(data){
                // if no data is set
                if(! data ){
                    // draw error message and return false
                    alert('Something went wrong!');
                    return false;
                }
                else    // ajax was successful
                    {
                        // hide the complete form
                        // $("#form").hide();
                        // $("#formTitle").hide();
                        $("#formWrapper").hide();

                        // check name to set correct thank you message
                        if (name)
                        {   // name is sent, set name as user
                            user = name;
                        }
                        else
                        {   // name is not sent, set email as user
                            user = email;
                        }

                        // append thank you html markup
                        $("#thankYouMessage").append('<h2>Thank you '+user+' <small>for subscribing to the newsletter!</small></h2>');
                        // FX: fade in thank you message
                        $(data).hide().prependTo("#thankYouMessage").fadeIn(820);
                    }
            }
        });
    });
});