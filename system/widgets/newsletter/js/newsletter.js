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

                myTimer = setTimeout(function() {
                    // call validation settings
                    checkForm();
                }, 400); //delay time in milliseconds
            });
        }

        function checkForm(){
            $('#form').validate({ // initialize the plugin
                errorPlacement: function(error, element) {
                    error.insertBefore(element);
                },
                rules: {
                 /*   name: {
                        required: true,
                        minlength: 4,
                        maxlength: 48
                    },*/
                    email: {
                        required: true,
                        email: true,
                        maxlength: 128
                    }
                }
            });
        }


    $('#submit').click(function(){
        var	email =	$('#email').val();
        if (!email.trim()) {
        //    alert('Please insert your email!');
            $( "#form" ).effect( "shake", {times:2}, 600 );
            return false;
        }
        else
            {
                checkForm();
            }
        /*
        if (!name.trim()) {
            alert('Please insert your name!');
            return false;
        }
        */

        $.ajax({
            url:'system/widgets/newsletter/js/newsletter.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            // data:'name='+name+'&email='+email,
            data:'email='+email,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $("#form").hide();
                    $("#comingTeaser").append('<h2>Thank you '+email+'</h2>');
                     // $(data).hide().prependTo("#comingTeaser").fadeIn(820);
                     // $("#newsletterTitle").hide();
                }
            }
        });

    });
});