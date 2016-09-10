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

    $('#submit').click(function(){
        checkForm();
        var	name 		=	$('#name').val();
        var	email 		=	$('#email').val();
        if (!email.trim()) {
            alert('Bitte gib Deine Emailadresse ein!');
            return false;
        }
        if (!name.trim()) {
            alert('Bitte gib Deinen Namen ein!');
            return false;
        }

        $.ajax({
            url:'system/widgets/newsletter/js/newsletter.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            data:'name='+name+'&email='+email,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $("#form").hide();
                   // $("#newsletter").append(data);
                    $(data).hide().prependTo("#newsletter").fadeIn(820);
                    $("#newsletterTitle").hide();
                }
            }
        });
    });
});