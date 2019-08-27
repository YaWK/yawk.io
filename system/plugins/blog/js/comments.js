    $(document).ready(function(){

        // auto-open blog comments accordeon
            $("#comments").collapse('show');
            // hide open/close comments button
            // $("#commentsBtn").hide();

        $('#submit_post').click(function(){
        var	name 		=	$('#name').val();
        var	email 		=	$('#email').val();
        var comment		=	$('#comment').val();
        var blogid		=	$('#blogid').val();
        var itemid		=	$('#itemid').val();
        var uid 		=	$('#uid').val();
        var gid		    =	$('#gid').val();

        if (!comment.trim()) {
            alert('Please enter comment');
            return false;
        }

        $.ajax({
            url:'system/plugins/blog/js/add-comment.php',
            type:'post',
            data:'name='+name+'&email='+email+'&comment='+comment+'&blogid='+blogid+'&itemid='+itemid+'&uid='+uid+'&gid='+gid,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                    $(data).hide().prependTo($("#comment_thread")).fadeIn(820);
                    //reset input boxes
                    $('#name').val('');
                    $('#email').val('');
                    $('#comment').val('');
                    $('#comments_btn').val('');
            },
            error:function()
            {
                alert('there was an error!');
            }
        });
    });
});