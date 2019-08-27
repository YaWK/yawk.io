$(document).ready(function(){

    // set vars for voting
    var votingAmount = 1;
    var	itemid = $('#itemid').val();

    // the fields to update the view
    var totalVotesText = $('#totalVotesText');
    var voteUpText = $('#voteUpText');
    var voteDownText = $('#voteDownText');

    var voteUpIcon = $('#voteUpIcon');
    var voteDownIcon = $('#voteDownIcon');

    // the vars (data)
    var totalVotes = $(totalVotesText).text();
    var voteUp = $(voteUpText).text();
    var voteDown = $(voteDownText).text();


    // VOTE UP BUTTON CLICKED
    $('#voteUp').click(function(){

        $.ajax({
            url:'system/plugins/blog/js/vote-up.php',
            type:'post',
            data:'voteUp='+votingAmount+'&itemid='+itemid,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    // UPDATE THE VOTING VIEW (user voted UP)

                    // check if user has already voted
                    // var voted = localStorage.getItem('voted');
                    // if (voted > 1)
                    // {
                        // add color to thumb
                        $(voteUpIcon).addClass('fa fa-thumbs-up');
                        $(voteUpIcon).addClass('animated bounceIn');
                        // add total votes
                        totalVotes++;
                        voteUp++;
                        // update upvotes
                        voteUpText.html(voteUp);
                        // update the view
                        totalVotesText.html(totalVotes);

                        // set local storage
                       // localStorage.setItem('voted', '1');
                    // }
                }
            }
        });
    });

    // VOTE DOWN BUTTON CLICKED
    $('#voteDown').click(function(){

        $.ajax({
            url:'system/plugins/blog/js/vote-down.php',
            type:'post',
            data:'voteDown='+votingAmount+'&itemid='+itemid,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    // UPDATE THE VOTING VIEW (user voted DOWN)

                    // add color to thumb
                    $(voteDownIcon).addClass('fa fa-thumbs-down');
                    $(voteDownIcon).addClass('animated bounceIn');
                    // add total votes
                    totalVotes++;
                    voteDown++;
                    // update upvotes
                    voteDownText.html(voteDown);
                    // update the view
                    totalVotesText.html(totalVotes);
                    localStorage.setItem('voted', '1');
                }
            }
        });
    });
});