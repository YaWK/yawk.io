$(document).ready(function(){

    // VOTE UP BUTTON CLICKED
    $('#voteUp').click(function(){
        var voteUp = 1;
        var	itemid = $('#itemid').val();
        $.ajax({
            url:'system/plugins/blog/js/vote-up.php',
            type:'post',
            data:'voteUp='+voteUp+'&itemid='+itemid,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $('#voteUp').addClass('fa fa-thumbs-up');
                }
            }
        });
    });
});