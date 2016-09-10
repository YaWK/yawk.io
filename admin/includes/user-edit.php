<?php
    if (!isset($user))
    {   // no username obj is set
        if (isset($_GET['user']))
        {   // create new user obj
            $user = new \YAWK\user();
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
        $user->username = htmlentities($_POST['username']);
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
                    echo "File is an image - " . $check["mime"] . ".";
                    // upload good
                    $uploadOk = 1;
                }
                else
                {   // throw error
                  echo "File is not an image.";
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
                  echo \YAWK\alert::draw("warning", "Sorry!", "Your file is too large. Your Image should be smaller than 2 MB.","page=users","4800");
                  $uploadOk = 0;
              }

            // Allow certain file formats

            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
               if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
                  echo \YAWK\alert::draw("warning", "Sorry!", "Only JPG, JPEG, PNG or GIF files are allowed.","page=users","4800");
                  $uploadOk = 0;
              }

          // Check if $uploadOk is set to 0 by an error
              if ($uploadOk == 0) {
                  echo \YAWK\alert::draw("danger", "Error!", "Your file was not uploaded!","page=users","4800");
            // if everything is ok, try to upload file
              } else {
                  if (!move_uploaded_file($_FILES["userpicture"]["tmp_name"], $target_file)) {
                      echo \YAWK\alert::draw("danger", "Error!", "There was an error uploading your file. Check folder chmod!","page=users","4800");
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
        $subtext = "$lang[EDIT] profile of "."&nbsp;"."$_GET[user]";
        echo \YAWK\backend::getTitle($lang['USER_PROFILE'], $subtext);
        echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=users\" title=\"Users\"> Users</a></li>
            <li class=\"active\"><a href=\"index.php?page=user-edit&user=$_GET[user]\" title=\"Edit User\"> Edit User</a></li>
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
<form name="form" enctype="multipart/form-data" class="form" action="index.php?page=user-edit&user=<?PHP echo $user->username; ?>" method="post">
    <input name="save" id="savebutton" type="submit" class="btn btn-success pull-right" value="speichern" />
    <a class="btn btn-default pull-right" href="index.php?page=users">zur&uuml;ck</a>
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="box box-default">
                <div class="box-body box-profile">
                    <?php echo YAWK\user::getUserImage("backend","$user->username", "profile-user-img img-responsive img-circle", '140', '140'); ?>
                    <!-- <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->

                    <h3 class="profile-username text-center"><?php echo \YAWK\backend::getFullUsername($user); ?></h3>

                    <p class="text-muted text-center"><?php echo \YAWK\user::getGroupNameFromID($db, $user->gid); if (!empty($user->job)) echo " & $user->job"; ?><br>Member since <?php $date = \YAWK\sys::splitDateShort($user->date_created);
                        echo "<small>($date[month], $date[day] $date[year], $date[time])</small>"; ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                                <?php
                                // count user friends
                                $i_followers = \YAWK\user::countMyFollowers($db, $user->id);
                                if ($i_followers > 0)
                                {
                                    $followersLink = "<a href=\"index.php?page=list-follower&uid=$user->id\">Followers</a>";
                                }
                                else
                                {
                                    $followersLink = "Follower";
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
                                $i_friends = \YAWK\user::countMyFriends($db, $user->id);
                                if ($i_friends > 0)
                                {
                                    $friendlistLink = "<a href=\"index.php?page=friendslist&uid=$user->id\">Friends</a>";
                                }
                                else
                                {
                                    $friendlistLink = "Friends";
                                }
                                ?>
                                <b><?php echo $friendlistLink; ?></b> <a class="pull-right"><?php echo $i_friends ?></a>
                        </li>
                    </ul>

                    <?php
                    // to display the follow/like/friendship buttons correctly,
                    // we need to detect, if the current profile's user is equal
                    // to the current, logged in user (admin) uid
                    $follow_status = \YAWK\user::checkFollowStatus($db, $_SESSION['uid'], $user->id);
                    $isFriend = \YAWK\user::isFriend($db, $_SESSION['uid'], $user->id);
                    $friends = \YAWK\user::isFriendRequested($db, $_SESSION['uid'], $user->id);

                    if ($follow_status === true)
                    {
                        $followBtn = "<a href=\"#\" id=\"unfollowBtn\" title=\"click to un-follow\" onclick=\"unfollowUser($_SESSION[uid], $user->id, '$user->username' )\" name=\"unfollowUser\" class=\"btn btn-success btn-block\"><b>You follow $user->username </b></a>";
                    }
                    else
                    {   // avoid to show follow button to yourself
                        if ($_SESSION['uid'] != ($user->id))
                        {   // follow request btn
                            $followBtn = "<a href=\"#\" id=\"followBtn\" onclick=\"followUser($_SESSION[uid], $user->id, '$user->username')\" name=\"followUser\" class=\"btn btn-primary btn-block\"><b>Follow me</b></a>";
                        }
                        else
                        {
                            $followBtn = 'You cannot follow yourself.<br>';
                        }
                    }
                    echo $followBtn;


                    if ($isFriend === true)
                    {
                       // $friendBtn = "<a href=\"#\" id=\"unfriendBtn\" title=\"click to un-friend\" onclick=\"unfriendUser($_SESSION[uid], $user->id, '$user->username' )\" name=\"unfriendUser\" class=\"btn btn-success btn-block\"><b>You are friend with $user->username </b></a>";
                        $friendBtn = "<button id=\"unfriendBtn\" title=\"You are friends.\" class=\"btn btn-success btn-block\"><b>You are friend with $user->username </b></button>";
                    }
                    else
                    {   // avoid to show friend request button to yourself
                        if ($_SESSION['uid'] != ($user->id))
                        {   // friend request btn
                            $friendBtn = "<a href=\"#\" id=\"friendBtn\" onclick=\"friendUser($_SESSION[uid], $user->id, '$user->username')\" name=\"friendUser\" class=\"btn btn-primary btn-block\"><b>Ask for my friendship</b></a>";
                        }
                        else
                        {
                            $friendBtn = 'You cannot send yourself a friend request.';
                        }
                    }

                    foreach ($friends as $friend)
                    {
                        if ($_SESSION['uid'] == $friend['friendA'])
                        {
                            $btnText = "Request has been sent to $user->username";
                        }
                        elseif ($_SESSION['uid'] == $friend['friendB'])
                        {
                            $btnText = "Request has been sent from $user->username";
                        }

                        if ($friend['confirmed'] == 0)
                        {
                            $friendBtn = "<a href=\"#\" id=\"confirmBtn\" title=\"waiting for $user->username to respond...\" name=\"unfriendUser\" class=\"btn btn-warning btn-block\"><b>$btnText</b></a>";
                        }
                        if ($friend['aborted'] == 1)
                        {
                            $btnText = "$user->username declined your friend request.";
                            $friendBtn = "<button id=\"blockedBtn\" title=\"aborted\" class=\"btn btn-danger btn-block\"><b>$btnText</b></button>";
                            $friendBtn .= "<a id=\"askBtn\" class=\"btn btn-default btn-block\" title=\"$user->username rejected your request\" style=\"display: none;\" href=\"index.php?plugin=messages&pluginpage=mailbox&active=compose&to=$user->username\"><b>send a message and ask why</b></a>";
                        }
                    }

                    echo $friendBtn;

                    // follow btn
                    echo "<a href=\"#\" id=\"followBtn\" onclick=\"followUser($_SESSION[uid], $user->id, '$user->username')\" style=\"display:none;\" name=\"followUser\" class=\"btn btn-primary btn-block\"><b>Follow me</b></a>";
                    // un - follow btn
                    echo "<a href=\"#\" id=\"unfollowBtn\" onclick=\"unfollowUser($_SESSION[uid], $user->id, '$user->username' )\" style=\"display: none;\" name=\"unfollowUser\" class=\"btn btn-success btn-block\"><b>You follow $user->username </b></a>";
                    // avoid to show yourself friend request btn
                    if ($_SESSION['uid'] != ($user->id))
                    {   // friend request button
                        echo "<a href=\"#\" id=\"friendBtn\" onclick=\"friendUser($_SESSION[uid], $user->id, '$user->username')\" style=\"display:none;\" name=\"friendUser\" class=\"btn btn-primary btn-block\"><b>Ask for my friendship</b></a>";
                    }
                    // unfriend btn
                    echo "<a href=\"#\" id=\"unfriendBtn\" title=\"You are friends!\" style=\"display:none;\" class=\"btn btn-success btn-block\"><b>You are friend with $user->username </b></a>";
                    // confirm btn
                    echo "<a href=\"#\" id=\"confirmBtn\" title=\"click to un-friend\" style=\"display:none;\" name=\"unfriendUser\" class=\"btn btn-warning btn-block\"><b>Request has been sent to $user->username </b></a>";

                    ?>

                    <!-- <a href="#" id="likeUser" class="btn btn-primary btn-block"><b>Like me</b></a>-->
                    <!-- <a href="#" id="requestFriendship" class="btn btn-primary btn-block"><b>Ask for my friendship</b></a> -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <?PHP // if ($user->gid <= 5) { ?>

            <div class="box box-default">
             <div class="box-body">
            <label>Assign to Group
                <select name="gid" style="width: 240px;" class="form-control">
                    <option value="<?PHP echo $user->gid; ?>"><?php echo $user->getGroupNameFromID($db, $user->gid); ?></option>
                    <option value="1">---</option>
                    <?PHP
                    foreach(YAWK\sys::getGroups($db, "users") as $role){

                        echo "<option value=\"".$role['id']."\"";
                        echo ">".$role['value']."</option>";
                    }
                    ?>
                </select>
            </label>

            <label for="job">Admin Job Description<input type="text" id="job" name="job" value="<?php echo $user->job; ?>" placeholder="eg. Comment Observer" class="form-control"></label>
            <?PHP if ($user->blocked === '1') { $code1="checked=\"checked\""; } else $code1=""; ?>
            <?PHP if ($user->privacy === '1') { $code2="checked=\"checked\""; } else $code2=""; ?>

            <label for="mystatus"><input type="checkbox" id="mystatus" name="mystatus" value="1" <?PHP echo $code1 ?>> Login sperren?</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="privacy"><input type="checkbox" id="privacy" name="privacy" value="1" <?PHP echo $code2 ?>> Hide from Who is online?</label>&nbsp;

                </div>
            </div>

            <!-- ##### USER PIC UPLOAD ##### -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-photo"></i><i class="fa fa-user"></i> Your Photo <small>upload a new picture</small></h3>
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
                <h3 class="box-title">Essential User Data <small>username, email & password</small></h3>
            </div>
                <div class="box-body">
            <?PHP if ($user->username === "admin" OR $user->username === "root")
                  {
                      $disabled="disabled aria-disabled=\"true\" title=\"$user->username is the only username that shall not be changed.\" readonly=\"readonly\"";
                  }
                  else
                  {
                      $disabled="";
                  }
            ?>

            <dl class="dl-horizontal">
                <dt><label for="username"><b class="fa fa-user"></b> &nbsp;Username</label></dt>
                <dd><input type="text" id="username" name="username" class="form-control" maxlength="100" <?PHP echo $disabled; ?> value="<?PHP echo $user->username; ?>"></dd>

                <dt><label for="email"><b class="fa fa-envelope-o"></b> &nbsp;Email</label></dt>
                <dd><input type="text" id="email" name="email" class="form-control" maxlength="100" value="<?PHP echo $user->email; ?>"></dd>

                <dt><label for="password1"><b class="fa fa-key"></b> &nbsp;Password</label></dt>
                <dd><input name="password1" id="password1" type="password" class="form-control" maxlength="100" value="<?PHP echo $user->password; ?>"></dd>

                <dt><label for="password2"><b class="fa fa-key"></b> &nbsp;Password <small>(again)</small></label></dt>
                <dd><input name="password2" id="password2" type="password" class="form-control"maxlength="100" value="<?PHP echo $user->password; ?>">&nbsp; </dd>
            </dl>

                </div>
            </div>

<!-- OPTIONAL USER SETTINGS -->
  <div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-home"></i> Optional personal data <small>firstname, lastname & address</small></h3>
    </div>
    <div class="box-body">
        <dl class="dl-horizontal">
            <dt><label for="firstname">Firstname</label></dt>
            <dd><input type="text" class="form-control" id="firstname" name="firstname" maxlength="100" value="<?PHP echo $user->firstname; ?>"></dd>

            <dt><label for="lastname">Lastname</label></dt>
            <dd><input type="text" class="form-control" id="lastname" name="lastname" maxlength="100" value="<?PHP echo $user->lastname; ?>"></dd>

            <dt><label for="street">Street</label></dt>
            <dd><input type="text" class="form-control" id="street" name="street" maxlength="100" value="<?PHP echo $user->street; ?>"></dd>

            <dt><label for="zipcode">ZIP code</label></dt>
            <dd><input type="text" class="form-control" id="zipcode" name="zipcode" maxlength="12" value="<?PHP echo $user->zipcode; ?>"></dd>

            <dt><label for="city">City</label></dt>
            <dd><input type="text" class="form-control" id="city" name="city" maxlength="100" value="<?PHP echo $user->city; ?>"></dd>

            <dt><label for="country">Country</label></dt>
            <dd><input type="text" class="form-control" id="country" name="country" maxlength="100" value="<?PHP echo $user->country; ?>"></dd>
        </dl>
    </div>
  </div>

<!-- SOCIAL MEDIA USER SETTINGS -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-facebook-official"></i> Social Media Links <small>website, twitter, facebook</small></h3>
        </div>
        <div class="box-body">
            <dl class="dl-horizontal">
                <dt><label for="url"><i class="fa fa-globe"></i> Website</label></dt>
                <dd><input type="text" class="form-control" placeholder="http://www.yourdomain.com/" id="url" name="url" maxlength="100" value="<?PHP echo $user->url; ?>"></dd>

                <dt><label for="twitter"><i class="fa fa-twitter"></i> Twitter</label></dt>
                <dd><input type="text" class="form-control" placeholder="http://www.twitter.com/yourprofile" id="twitter" name="twitter" maxlength="100" value="<?PHP echo $user->twitter; ?>"></dd>

                <dt><label for="facebook"><i class="fa fa-facebook-official"></i> Facebook</label></dt>
                <dd><input type="text" class="form-control" placeholder="http://www.facebook.com/yourprofile" id="facebook" name="facebook" maxlength="100" value="<?PHP echo $user->facebook; ?>"></dd>
            </dl>

        </div>
     </div>

        </div>
    </div>

  </form>
