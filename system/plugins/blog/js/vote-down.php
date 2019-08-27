<?php
include '../../../classes/db.php';
if (!isset($db)) { $db = new \YAWK\db(); }
include '../../../classes/sys.php';
include '../classes/blog.php';
$voteDown		=	$_POST['voteDown'];
$itemid	    	=	$_POST['itemid'];
// get votes from table...
$res = $db->query("SELECT voteDown FROM {blog_items} WHERE id ='" . $itemid . "'");
$votes = mysqli_fetch_row($res);
if (!empty($votes[0])) {
    $votes = $votes[0];
}
else {
    $votes = 0;
}

// add vote from user to existing votes
$votes = $votes + $voteDown;

// update database with new votes
$res = $db->query("UPDATE {blog_items} SET voteDown = '".$votes."' WHERE id = '".$itemid."'");
if ($res){
    $html = "Update erfolgreich!";
}
else {
    $html = \YAWK\alert::draw("danger", "Ooops!", "This should not happen. Your like could not be set. Please try again!","","2500");
}
echo $html;