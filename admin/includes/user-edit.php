<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\user;

/** @var $db db */
/** @var $lang language */
if (!isset($user))
{   // no username obj is set
    if (isset($_GET['user']))
    {   // create new user obj
        $user = new user($db);
        // load properties for given user
        $user->loadProperties($db, $_GET['user']);
    }
}
else
{   // obj is set
    if (isset($_GET['user']))
    {   // user var is set,
        // load user properties
        $user->loadProperties($db, $_GET['user']);
    }
}

// if SAVE is clicked
if(isset($_POST['save']))
{   // prepare username
    $user->username = trim($user->username);
    $user->username = strip_tags($_POST['username']);
    if (isset($_FILES['userpicture']) && (!empty($_FILES['userpicture']['name'])))
    {   // if a user image is set,
        // check file extension...
        $file_ext = substr($_FILES['userpicture']['name'], 0, -4);  // get the last 3 chars
        if ($file_ext == ".jpg") {
            $ext = 'jpg';
        }
        elseif ($file_ext == "jpeg") {
            $ext = 'jpg';
        }
        elseif ($file_ext == ".gif") {
            $ext = 'gif';
        }
        elseif ($file_ext == "png") {
            $ext = 'png';
        }

        // SET USER IMAGE UPLOAD SETTINGS
        $target_dir = "../media/images/users/";
        $target_file = $target_dir . basename("$user->username.jpg");
        $uploadOk = 1;
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"]))
        {   // if user image form is sent
            $check = getimagesize($_FILES["userpicture"]["tmp_name"]);
            if($check !== false)
            {   // throw info
                // echo "File is an image - " . $check["mime"] . ".";
                // upload good
                $uploadOk = 1;
            }
            else
            {   // throw error
                // echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        /*
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
        */
        // Check file size
        if ($_FILES["userpicture"]["size"] > 2560000) {
            echo alert::draw("warning", "$lang[ERROR]", "$lang[FILE_UPLOAD_TOO_LARGE]","page=users","4800");
            $uploadOk = 0;
        }

        // Allow certain file formats
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            echo alert::draw("warning", "$lang[ERROR]", "$lang[UPLOAD_ONLY_IMG_ALLOWED]","page=users","4800");
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            echo alert::draw("danger", "$lang[ERROR]", "$lang[FILE_UPLOAD_FAILED]","page=users","4800");
            // if everything is ok, try to upload file
        }
        else
        {
            if (!move_uploaded_file($_FILES["userpicture"]["tmp_name"], $target_file))
            {
                echo alert::draw("danger", "$lang[ERROR]", "$lang[FILE_UPLOAD_ERROR_CHMOD]","page=users","4800");
            }
        }
    }
    // prepare password
    $password1 = htmlentities($_POST['password1']);
    $password2 = htmlentities($_POST['password2']);
    // check, if passwords match
    if ($password1 == $password2) {
        $password_check = $password1;
        // vermeidung von doppelter md5 kodierung
        if ($res = $db->query("SELECT password FROM {users} WHERE username='".$_GET['user']."'"))
        {
            $row = mysqli_fetch_row($res);
            // wenn pwd gleich wie db, dann db wert
            if ($row[0] == $password_check)
            {   // do not change password
                $user->password = $row[0];
            }
            else
            {   // set new user password
                $user->password = md5($password1);
            }

            // if no templateID was sent, set default template (id: 1) which should always be loadable
            if (empty($_POST['templateID'])) { $_POST['templateID'] = 1; }
            // if override template was not sent, set default value (0) which means user is not able to override tpl
            if (empty($_POST['overrideTemplate'])) { $_POST['overrideTemplate'] = 0; }

            // prepare vars
            $user->username = htmlentities($_POST['username']);
            $user->email = htmlentities($_POST['email']);
            $user->url = htmlentities($_POST['url']);
            $user->twitter = htmlentities($_POST['twitter']);
            $user->facebook = htmlentities($_POST['facebook']);
            $user->firstname = htmlentities($_POST['firstname']);
            $user->lastname = htmlentities($_POST['lastname']);
            $user->street = htmlentities($_POST['street']);
            $user->zipcode = htmlentities($_POST['zipcode']);
            $user->city = htmlentities($_POST['city']);
            $user->country = htmlentities($_POST['country']);
            $user->job = htmlentities($_POST['job']);
            $user->templateID = htmlentities($_POST['templateID']);
            $user->overrideTemplate = htmlentities($_POST['overrideTemplate']);
            $user->gid = htmlentities($_POST['gid']);

            if (!isset($_POST['privacy']) OR (empty($_POST['privacy'])))
            {
                $_POST['privacy'] = 0;
            }
            if (!isset($_POST['mystatus']) OR (empty($_POST['mystatus'])))
            {
                $_POST['mystatus'] = 0;
            }
            $user->privacy=$db->quote($_POST['privacy']);
            $user->blocked=$db->quote($_POST['mystatus']);
            // save user
            $user->save($db);
        }
    }
} //. end if isset [SAVE]

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
<!-- Content Wrapper. Contains page content -->
<div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['USER_PROFILE_EDIT'], $_GET['user']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=users\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=user-edit&user=$_GET[user]\" title=\"$lang[EDIT]: $_GET[user]\"> $_GET[user]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";

echo "<script type='text/javascript'>

        function followUser(uid, hunted, user) {
            // alert(uid);
            $.ajax({    // do ajax request
            url:'js/follow-user.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            data:'uid='+uid+'&hunted='+hunted+'&user='+user,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {

                    $(data).hide().appendTo('#followBtn');
                    $('#followBtn').hide()
                    $('#unfollowBtn').fadeIn(800);
                }
            }
        });
        }

        function unfollowUser(uid, hunted, user) {
            // alert(uid);
            $.ajax({    // do ajax request
            url:'js/follow-user.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            data:'uid='+uid+'&hunted='+hunted+'&user='+user,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $(data).hide().prependTo('#followBtn');
                    $('#unfollowBtn').hide(800);
                    $('#followBtn').show();
                }
            }
        });
        }

        function friendUser(uid, hunted, user) {
            // alert(uid);
            $.ajax({    // do ajax request
            url:'js/friend-user.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            data:'uid='+uid+'&hunted='+hunted+'&user='+user,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {

                    $(data).hide().prependTo('#friendBtn');
                    $('#friendBtn').hide()
                    $('#confirmBtn').fadeIn(800);

                }
            }
        });
        }

        function unfriendUser(uid, hunted, user) {
            // alert(uid);
            $.ajax({    // do ajax request
            url:'js/unfriend-user.php',
            type:'post',
            //    data:'name='+name+'&comment='+comment+'&id='+id,
            data:'uid='+uid+'&hunted='+hunted+'&user='+user,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $(data).hide().prependTo('#friendBtn');
                    $('#unfriendBtn').hide(800);
                    $('#friendBtn').show();
                }
            }
        });
        }

      </script>";
?>

<!-- FORM -->
<form name="form" enctype="multipart/form-data" class="form" action="index.php?page=user-edit&user=<?php echo $user->username; ?>" method="post">
    <input name="save" id="savebutton" type="submit" class="btn btn-success pull-right" value="speichern" />
    <a class="btn btn-default pull-right" href="index.php?page=users">zur&uuml;ck</a>
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="box box-default">
                <div class="box-body box-profile">
                    <?php echo user::getUserImage("backend","$user->username", "profile-user-img img-responsive img-circle", '140', '140'); ?>

                    <h3 class="profile-username text-center"><?php echo backend::getFullUsername($user); ?></h3>

                    <p class="text-muted text-center"><?php echo user::getGroupNameFromID($db, $user->gid); if (!empty($user->job)) echo " & $user->job"; ?><br>Member since <?php $date = \YAWK\sys::splitDateShort($user->date_created);
                        echo "<small>($date[month], $date[day] $date[year], $date[time])</small>"; ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <?php
                            // count user friends
                            $i_followers = user::countMyFollowers($db, $user->id);
                            if ($i_followers > 0)
                            {
                                $followersLink = "<a href=\"index.php?page=list-follower&uid=$user->id\">$lang[FOLLOWERS]</a>";
                            }
                            else
                            {
                                $followersLink = "$lang[FOLLOWER]";
                            }
                            ?>
                            <b><?php echo $followersLink; ?></b> <a class="pull-right"><?php echo $i_followers ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Likes</b> <a class="pull-right"><?php echo $user->likes; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>
                                <?php
                                // count user friends
                                $i_friends = user::countMyFriends($db, $user->id);
                                if ($i_friends > 0)
                                {
                                    $friendlistLink = "<a href=\"index.php?page=friendslist&uid=$user->id\">$lang[FRIENDS]</a>";
                                }
                                else
                                {
                                    $friendlistLink = "$lang[FRIENDS]";
                                }
                                ?>
                                <b><?php echo $friendlistLink; ?></b> <a class="pull-right"><?php echo $i_friends ?></a>
                        </li>
                    </ul>

                    <?php
                    // to display the follow/like/friendship buttons correctly,
                    // we need to detect, if the current profile's user is equal
                    // to the current, logged in user (admin) uid
                    $follow_status = user::checkFollowStatus($db, $_SESSION['uid'], $user->id);
                    $isFriend = user::isFriend($db, $_SESSION['uid'], $user->id);
                    $friends = user::isFriendRequested($db, $_SESSION['uid'], $user->id);

                    if ($follow_status === true)
                    {
                        $followBtn = "<a href=\"#\" id=\"unfollowBtn\" title=\"click to un-follow\" onclick=\"unfollowUser($_SESSION[uid], $user->id, '$user->username' )\" name=\"unfollowUser\" class=\"btn btn-success btn-block\"><b>$lang[YOU_FOLLOW] $user->username </b></a>";
                    }
                    else
                    {   // avoid to show follow button to yourself
                        if ($_SESSION['uid'] != ($user->id))
                        {   // follow request btn
                            $followBtn = "<a href=\"#\" id=\"followBtn\" onclick=\"followUser($_SESSION[uid], $user->id, '$user->username')\" name=\"followUser\" class=\"btn btn-primary btn-block\"><b>$lang[FOLLOW_ME]</b></a>";
                        }
                        else
                        {
                            $followBtn = $lang['FOLLOW_YOURSELF_FAIL'].'<br>';
                        }
                    }
                    echo $followBtn;

                    if ($isFriend === true)
                    {
                        $friendBtn = "<button id=\"unfriendBtn\" title=\"$lang[YOU_ARE_FRIENDS]\" class=\"btn btn-success btn-block\"><b>$lang[YOU_ARE_FRIEND_WITH] $user->username </b></button>";
                    }
                    else
                    {   // avoid to show friend request button to yourself
                        if ($_SESSION['uid'] != ($user->id))
                        {   // friend request btn
                            $friendBtn = "<a href=\"#\" id=\"friendBtn\" onclick=\"friendUser($_SESSION[uid], $user->id, '$user->username')\" name=\"friendUser\" class=\"btn btn-primary btn-block\"><b>$lang[ASK_FOR_MY_FRIENDSHIP]</b></a>";
                        }
                        else
                        {
                            $friendBtn = $lang['FRIENDSHIP_SELF_FAIL'];
                        }
                    }

                    foreach ($friends as $friend)
                    {
                        if ($_SESSION['uid'] == $friend['friendA'])
                        {
                            $btnText = "$lang[FRIEND_REQUEST_SENT_TO] $user->username";
                        }
                        elseif ($_SESSION['uid'] == $friend['friendB'])
                        {
                            $btnText = "$lang[FRIEND_REQUEST_SENT_TO] $user->username";
                        }

                        if ($friend['confirmed'] == 0)
                        {
                            $friendBtn = "<a href=\"#\" id=\"confirmBtn\" title=\"$lang[FRIEND_AWAITING_RESPONSE] $user->username\" name=\"unfriendUser\" class=\"btn btn-warning btn-block\"><b>$btnText</b></a>";
                        }
                        if ($friend['aborted'] == 1)
                        {
                            $btnText = "$user->username $lang[DECLINED_FRIEND_REQUEST]";
                            $friendBtn = "<button id=\"blockedBtn\" title=\"$lang[ABORTED]\" class=\"btn btn-danger btn-block\"><b>$btnText</b></button>";
                            $friendBtn .= "<a id=\"askBtn\" class=\"btn btn-default btn-block\" title=\"$user->username $lang[FRIENDSHIP_REJECTED]\" style=\"display: none;\" href=\"index.php?plugin=messages&pluginpage=mailbox&active=compose&to=$user->username\"><b>$lang[ASK_WHY_REJECTED]</b></a>";
                        }
                    }

                    echo $friendBtn;

                    // follow btn
                    echo "<a href=\"#\" id=\"followBtn\" onclick=\"followUser($_SESSION[uid], $user->id, '$user->username')\" style=\"display:none;\" name=\"followUser\" class=\"btn btn-primary btn-block\"><b>$lang[FOLLOW_ME]</b></a>";
                    // un - follow btn
                    echo "<a href=\"#\" id=\"unfollowBtn\" onclick=\"unfollowUser($_SESSION[uid], $user->id, '$user->username' )\" style=\"display: none;\" name=\"unfollowUser\" class=\"btn btn-success btn-block\"><b>$lang[YOU_FOLLOW] $user->username </b></a>";
                    // avoid to show yourself friend request btn
                    if ($_SESSION['uid'] != ($user->id))
                    {   // friend request button
                        echo "<a href=\"#\" id=\"friendBtn\" onclick=\"friendUser($_SESSION[uid], $user->id, '$user->username')\" style=\"display:none;\" name=\"friendUser\" class=\"btn btn-primary btn-block\"><b>$lang[ASK_FOR_MY_FRIENDSHIP]</b></a>";
                    }
                    // unfriend btn
                    echo "<a href=\"#\" id=\"unfriendBtn\" title=\"You are friends!\" style=\"display:none;\" class=\"btn btn-success btn-block\"><b>$lang[YOU_ARE_FRIEND_WITH] $user->username </b></a>";
                    // confirm btn
                    echo "<a href=\"#\" id=\"confirmBtn\" title=\"click to un-friend\" style=\"display:none;\" name=\"unfriendUser\" class=\"btn btn-warning btn-block\"><b>$lang[REQUEST_HAS_BEEN_SENT] $user->username </b></a>";

                    ?>

                    <!-- <a href="#" id="likeUser" class="btn btn-primary btn-block"><b>Like me</b></a>-->
                    <!-- <a href="#" id="requestFriendship" class="btn btn-primary btn-block"><b>Ask for my friendship</b></a> -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <?php // if ($user->gid <= 5) { ?>

            <div class="box box-default">
                <div class="box-body">
                    <label><?php echo $lang['ASSIGN_TO_GROUP']; ?>
                        <select name="gid" style="width: 240px;" class="form-control">
                            <option value="<?php echo $user->gid; ?>"><?php echo $user->getGroupNameFromID($db, $user->gid); ?></option>
                            <option value="1">---</option>
                            <?php
                            foreach(YAWK\sys::getGroups($db, "users") as $role){

                                echo "<option value=\"".$role['id']."\"";
                                echo ">".$role['value']."</option>";
                            }
                            ?>
                        </select>
                    </label>

                    <label for="job"><?php echo $lang['JOB_DESCRIPTION']; ?><input type="text" id="job" name="job" value="<?php echo $user->job; ?>" placeholder="<?php echo $lang['JOB_PLACEHOLDER']; ?>" class="form-control"></label>
                    <?php if ($user->blocked === '1') { $code1="checked=\"checked\""; } else $code1=""; ?>
                    <?php if ($user->privacy === '1') { $code2="checked=\"checked\""; } else $code2=""; ?>

                    <label for="mystatus"><input type="checkbox" id="mystatus" name="mystatus" value="1" <?php echo $code1 ?>> <?php echo $lang['LOGIN_LOCK']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="privacy"><input type="checkbox" id="privacy" name="privacy" value="1" <?php echo $code2 ?>> <?php echo $lang['HIDE_FROM_WHOIS_ONLINE']; ?></label>&nbsp;

                </div>
            </div>

            <!-- ##### TEMPLATE OVERRIDE SETTINGS ##### -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-cube"></i> <?php echo "$lang[TPL] <small>$lang[TPL_USER_DEFINED]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <label for="templateID"><?php echo $lang['TPL']." ".$lang['ID']; ?>
                        <input type="text" style="width:75px;" id="templateID" name="templateID" value="<?php echo $user->templateID; ?>" placeholder="<?php echo $lang['ID']; ?>" class="form-control">
                    </label>
                    <label for="overrideTemplate"><?php echo $lang['TPL_ALLOW_OVERRIDE']; ?>
                        <select id="overrideTemplate" name="overrideTemplate" class="form-control">
                            <?php
                            if ($user->overrideTemplate == 1)
                            {
                                echo '<option value="1" selected>'.$lang['ALLOWED'].'</option>';
                                echo '<option value="0">'.$lang['FORBIDDEN'].'</option>';
                            }
                            else {
                                echo '<option value="0" selected>'.$lang['FORBIDDEN'].'</option>';
                                echo '<option value="1">'.$lang['ALLOWED'].'</option>';

                            }
                            ?>
                        </select>
                    </label>
                </div>
            </div>


            <!-- ##### USER PIC UPLOAD ##### -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-photo"></i> <?php echo "$lang[YOUR_PHOTO] <small>$lang[UPLOAD_A_NEW_PIC]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <?php  echo YAWK\user::getUserImage("backend","$user->username", "img-circle", 140, 140); ?>
                    <input type="file" class="btn btn-warning" name="userpicture" id="userpicture">
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "$lang[USER_DATA] <small>$lang[USERNAME_EMAIL_PWD]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <?php if ($user->username === "admin" OR $user->username === "root")
                    {
                        $disabled="title=\"$user->username $lang[NOT_CHANGEABLE]\" readonly=\"readonly\"";
                    }
                    else
                    {
                        $disabled="";
                    }
                    ?>

                    <dl class="dl-horizontal">
                        <dt><label for="username"><b class="fa fa-user"></b> &nbsp;<?php echo $lang['USERNAME']; ?></label></dt>
                        <dd><input type="text" id="username" name="username" class="form-control" maxlength="100" <?php echo $disabled; ?> value="<?php echo $user->username; ?>"></dd>

                        <dt><label for="email"><b class="fa fa-envelope-o"></b> &nbsp;<?php echo $lang['EMAIL']; ?></label></dt>
                        <dd><input type="text" id="email" name="email" class="form-control" maxlength="100" value="<?php echo $user->email; ?>"></dd>

                        <dt><label for="password1"><b class="fa fa-key"></b> &nbsp;<?php echo $lang['PASSWORD']; ?></label></dt>
                        <dd><input name="password1" id="password1" type="password" class="form-control" maxlength="100" value="<?php echo $user->password; ?>"></dd>

                        <dt><label for="password2"><b class="fa fa-key"></b> &nbsp;<?php echo $lang['PASSWORD']; ?><br><small><?php echo $lang['REPEAT']; ?></small></label></dt>
                        <dd><input name="password2" id="password2" type="password" class="form-control"maxlength="100" value="<?php echo $user->password; ?>">&nbsp; </dd>
                    </dl>

                </div>
            </div>

            <!-- OPTIONAL USER SETTINGS -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-home"></i> <?php echo "$lang[OPTIONAL_PERSONAL_DATA] <small>$lang[FIRSTNAME_LASTNAME_ADDRESS]"; ?></small></h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><label for="firstname"><?php echo $lang['FIRSTNAME']; ?></label></dt>
                        <dd><input type="text" class="form-control" id="firstname" name="firstname" maxlength="100" value="<?php echo $user->firstname; ?>"></dd>

                        <dt><label for="lastname"><?php echo $lang['LASTNAME']; ?></label></dt>
                        <dd><input type="text" class="form-control" id="lastname" name="lastname" maxlength="100" value="<?php echo $user->lastname; ?>"></dd>

                        <dt><label for="street"><?php echo $lang['STREET']; ?></label></dt>
                        <dd><input type="text" class="form-control" id="street" name="street" maxlength="100" value="<?php echo $user->street; ?>"></dd>

                        <dt><label for="zipcode"><?php echo $lang['ZIPCODE']; ?></label></dt>
                        <dd><input type="text" class="form-control" id="zipcode" name="zipcode" maxlength="12" value="<?php echo $user->zipcode; ?>"></dd>

                        <dt><label for="city"><?php echo $lang['CITY']; ?></label></dt>
                        <dd><input type="text" class="form-control" id="city" name="city" maxlength="100" value="<?php echo $user->city; ?>"></dd>

                        <dt><label for="country"><?php echo $lang['COUNTRY']; ?></label></dt>
                        <dd><input type="text" class="form-control" id="country" name="country" maxlength="100" value="<?php echo $user->country; ?>"></dd>
                    </dl>
                </div>
            </div>

            <!-- SOCIAL MEDIA USER SETTINGS -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-facebook-official"></i> <?php echo "$lang[SOCIAL_MEDIA_LINKS] <small>$lang[WEBSITE], $lang[TWITTER], $lang[FACEBOOK]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><label for="url"><i class="fa fa-globe"></i> <?php echo "$lang[WEBSITE]"; ?></label></dt>
                        <dd><input type="text" class="form-control" placeholder="http://www.yourdomain.com/" id="url" name="url" maxlength="100" value="<?php echo $user->url; ?>"></dd>

                        <dt><label for="twitter"><i class="fa fa-twitter"></i> <?php echo "$lang[TWITTER]"; ?></label></dt>
                        <dd><input type="text" class="form-control" placeholder="http://www.twitter.com/yourprofile" id="twitter" name="twitter" maxlength="100" value="<?php echo $user->twitter; ?>"></dd>

                        <dt><label for="facebook"><i class="fa fa-facebook-official"></i> <?php echo "$lang[FACEBOOK]"; ?></label></dt>
                        <dd><input type="text" class="form-control" placeholder="http://www.facebook.com/yourprofile" id="facebook" name="facebook" maxlength="100" value="<?php echo $user->facebook; ?>"></dd>
                    </dl>

                </div>
            </div>
        </div>
    </div>
</form>
