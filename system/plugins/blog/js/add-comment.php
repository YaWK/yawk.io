<?php
include '../../../classes/db.php';
if (!isset($db)) { $db = new \YAWK\db(); }
include '../../../classes/sys.php';
	$blogid		=	$_POST['blogid'];
	$itemid		=	$_POST['itemid'];
	$uid		=	$_POST['uid'];
	$gid		=	$_POST['gid'];
	$ip			= 	$_SERVER['REMOTE_ADDR'];
	$comment	=	$_POST['comment'];
	$name		=	$_POST['name'];
	$email		=	$_POST['email'];
    $now		= 	date("Y-m-d H:i:s");

    // if user is not logged in
    if ($uid === '0' || $gid === '0') {
        if (isset($_POST['email'])){
            $email =    $_POST['email'];
        } else {
            $email = "";
        }
    }
    else {
        $sql = $db->query("SELECT email FROM {users} WHERE id ='" . $uid . "' AND privacy = 0");
        $email = mysqli_fetch_row($sql);
        if (!empty($email[0])) {
            $email = $email[0];
        }
        else {
            $email = "";
        }
    }

    // remove HTML tags for security reasons
    $comment = str_replace("\n", "<br>", $comment);
    $name = strip_tags($name);
    // remove special chars
    $comment = \YAWK\sys::encodeChars($comment);
    $name    = \YAWK\sys::encodeChars($name);

/*
    if ($uid === '0' && $gid === '0') {
        $name = "Guest";
    }
*/

	if ($db->query("INSERT INTO {blog_comments} (blogid, itemid, uid, gid, ip, date_created, name, email, comment)
					 VALUES('$blogid', '$itemid', '$uid', '$gid', '$ip', '$now', '$name', '$email', '$comment')"))
	{
        $html		=	'';

        $date = \YAWK\sys::splitDate($now);
        $year = $date['year'];
        $month = $date['month'];
        $day = $date['day'];
        $time = $date['time'];
        $prettydate = "$day. $month $year $time";

        // if user is guest, show comment
        if ($uid === '0' || $gid === '0') {
            // draw guest comments
            $html .= "<p id=\"comment_thread\"><i><h5><strong>" . $name . "</strong> <small>on " . $prettydate . "</small></h5></i> <div style=\"padding-left: 0.3em;\">" . $comment . "</div></p><hr>";
        } else {
            // if uid != 0, it was a registered user, we want to get username for that uid
            $sql2 = $db->query("SELECT username FROM {users} WHERE id = '" . $uid . "'");
            while ($row2 = mysqli_fetch_row($sql2)) {
                if (!empty($email)){
                    // draw user comments
                    $html .= "<p id=\"comment_thread\"><i><h5><strong><a href=\"mailto:$email\">$row2[0]</a></strong> <small>am " . $prettydate . "</small></h5></i> <div style=\"padding-left: 0.3em;\">" . $comment . "</div></p><hr>";
                }
                else {
                    // draw user comments
                    $html .= "<p id=\"comment_thread\"><i><h5><strong>$row2[0]</strong> <small>am " . $prettydate . "</small></h5></i> <div style=\"padding-left: 0.3em;\">" . $comment . "</div></p><hr>";
                }
            }
        }
        echo $html;
    }
    else
        {
            echo "<p>There was an error saving your comment, we're sorry.</p>";
        }

