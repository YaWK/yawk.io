$(document).ready(function(){

    $('#submit_post').click(function(){
        var	msg_to      =	$('#msg_to').val();
        var msg_body	=	$('#msg_body').val();
        var fromUID 	=	$('#fromUID').val();
        var token   	=	$('#token').val();

        // filter &
        msg_body = encodeURIComponent(msg_body);

        if (!msg_body.trim()) {
            alert('Die Nachricht ist leer. Bitte Text eingeben!');
            return false;
        }

        $.ajax({
            url:'../system/plugins/messages/js/message-new.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            data:'msg_to='+msg_to+'&msg_body='+msg_body+'&fromUID='+fromUID+'&token='+token,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                   // $('#comment_thread').hide();
                   // $('#msg_success').fadeIn();
                    $(data).hide().prependTo("#comment_thread").fadeIn(820).delay( 2600 ).fadeOut( 420 );
                    //reset input boxes
                    $('#msg_to').val('');
                    $('#msg_body').val('');
                }
            }
        });
    });

});