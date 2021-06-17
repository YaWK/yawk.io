<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\user;

/** @var $db db */
/** @var $lang language */

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
<!-- Content Wrapper. Contains page content -->
<div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['USER'], $lang['USER_ADD_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=users\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=user-new\" title=\"".$lang['USER+']."\"> ".$lang['USER+']."</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";

   if(!isset($_POST['username'])){   ?>

<div class="box box-default">
    <div class="box-body">
<!-- ADD USER FORM -->
<form class="form" action="index.php?page=user-new" method="post">
    <div class="row">
        <div class="col-md-6">
    <h1><small><i class="fa fa-user">&nbsp; </i><?php echo "$lang[NAME], $lang[EMAIL], $lang[PASSWORD]"; ?></small></h1>
    <label for="username"><b><?php echo "$lang[USERNAME]"; ?></b></label> <input type="text" id="username" class="form-control" name="username" maxlength="100">
    <label for="email"><b><?php echo "$lang[EMAIL]"; ?></b></label><input type="text" id="email" class="form-control" name="email" maxlength="100">
    <label for="password1"><b><?php echo "$lang[PASSWORD]"; ?></b></label><input name="password1" id="password1" class="form-control" maxlength="100" type="password">&nbsp;
    <label for="password2"><b><?php echo "$lang[REPEAT]"; ?></b></label><input name="password2" id="password2" class="form-control" maxlength="100" type="password">&nbsp;<br><br>

    <input type="submit" id="savebutton" class="btn btn-success" value="<?php echo "$lang[CREATE_USER]"; ?>">
<br><br><hr>
      
    <h1><small><i class="fa fa-lock">&nbsp; </i><?php echo "$lang[DATA_ACCESS_AND_PRIVACY]"; ?></small></h1>
    <label>Assign to:
            <select name="gid" style="width: 240px;" class="form-control" >
	   		    <option value="2"><?php echo "$lang[USER]"; ?></option>
	   		    <option value="1">---</option>
					<?php
					  foreach(YAWK\sys::getGroups($db, "users") as $role){
					  
					    echo "<option value=\"".$role['id']."\"";
					    echo ">".$role['value']."</option>";
					  }
					?>
				</select>
		</label><br><br>	

    <label for="mystatus"><input name="mystatus" id="mystatus" value="1" type="checkbox" /><i class="fa fa-lock"></i> <?php echo "$lang[LOGIN_LOCK]"; ?></label>&nbsp;
    <label for="privacy"><input name="privacy" id="privacy" value="1" type="checkbox" /><i class="fa fa-eye-open"></i> <?php echo "$lang[HIDE_FROM_WHOIS_ONLINE]"; ?></label>&nbsp;
  <hr>
  </div>
        <div class="col-md-6">
<!-- new col -->  
<!-- OPTIONAL USER SETTINGS -->
	 <h1><small><i class="fa fa-home">&nbsp; </i><?php echo "$lang[OPTIONAL_PERSONAL_DATA]"; ?></small></h1>
    <label for="firstname"><?php echo "$lang[FIRSTNAME]"; ?>:</label><input type="text" class="form-control" id="firstname" name="firstname" maxlength="100">
    <label for="lastname"><?php echo "$lang[LASTNAME]"; ?>:</label><input type="text" class="form-control" id="lastname" name="lastname" maxlength="100">
    <label for="street"><?php echo "$lang[STREET]"; ?></label><input type="text" class="form-control" id="street" name="street" maxlength="100">
    <label for="zipcode"><?php echo "$lang[ZIPCODE]"; ?></label><input type="text" class="form-control" id="zipcode" name="zipcode" maxlength="12">
    <label for="city"><?php echo "$lang[CITY]"; ?></label><input type="text" class="form-control" id="city" name="city" maxlength="100">
    <label for="country"><?php echo "$lang[COUNTRY]"; ?></label><input type="text" class="form-control" id="country" name="country" maxlength="100">
	 <br>
	 <hr>
<!-- SOCIAL MEDIA USER SETTINGS -->
	 <h1><small><i class="fa fa-thumbs-o-up"></i> <?php echo "$lang[SOCIAL_MEDIA_LINKS]"; ?></small></h1>
    <label for="url"><i class="fa fa-globe"></i> <?php echo "$lang[WEBSITE]"; ?></label><input type="text" class="form-control" id="url" name="url" maxlength="100" placeholder="http://">
    <label for="twitter"><i class="fa fa-twitter"></i> <?php echo "$lang[TWITTER]"; ?></label><input type="text" class="form-control" id="twitter" name="twitter" maxlength="100" placeholder="http://www.twitter.com/username">
    <label for="facebook"><i class="fa fa-facebook"></i> <?php echo "$lang[FACEBOOK]"; ?></label><input type="text" class="form-control" id="facebook" name="facebook" maxlength="100" placeholder="http://www.facebook.com/username">
      </div>
    </div>
  </form>
</div>
</div>

<?php
  }
  else {
      $username = $db->quote($_POST['username']);
      $password1 = $db->quote($_POST['password1']);
      $password2 = $db->quote($_POST['password2']);
      $email = $db->quote($_POST['email']);
      $firstname = $db->quote($_POST['firstname']);
      $lastname = $db->quote($_POST['lastname']);
      $street = $db->quote($_POST['street']);
      $zipcode = $db->quote($_POST['zipcode']);
      $city = $db->quote($_POST['city']);
      $country = $db->quote($_POST['country']);
      $url = $db->quote($_POST['url']);
      $twitter = $db->quote($_POST['twitter']);
      $facebook = $db->quote($_POST['facebook']);
      $gid = $db->quote($_POST['gid']);

      if (isset($_POST['job']) && (!empty($_POST['job'])))
      {
          $job = $db->quote($_POST['job']);
      }
      else
      {
          $job = '';
      }

      if (!isset($_POST['privacy']) OR (empty($_POST['privacy'])))
      {
          $privacy = 0;
      }
      else
      {
          $privacy = $db->quote($_POST['privacy']);
      }
      // check blocked var
      if (!isset($_POST['mystatus']) OR (empty($_POST['mystatus'])))
      {
          $blocked = 0;
      }
      else
      {
          $blocked = $db->quote($_POST['mystatus']);
      }
      $gid = $db->quote($_POST['gid']);

   if (user::create($db, $username, $password1, $password2, $email,
   $url, $twitter, $facebook, $firstname, $lastname, $street, 
   $zipcode, $city, $country, $blocked, $privacy, $job, $gid))
    {
        print alert::draw("success", "$lang[SUCCESS]", "$lang[USER] <strong>".$username."</strong> $lang[ADDED]","page=users","1200");
    }
    else 
    {
        print alert::draw("danger", "$lang[ERROR]", "$lang[USER] <strong>".$username."</strong> $lang[NOT] $lang[ADDED]","page=users","4800");
    }
   
  }
?>
