<?php
if (isset($_SESSION['username'])) {
$user = $_SESSION['username'];
	} else { $user = ""; }

/* include core files */
$dirprefix = \YAWK\settings::getSetting($db, "dirprefix");
$dirprefix = substr($dirprefix, 1);
$currentWidgetPath = YAWK\widget::getCurrentWidgetPath($db)."loginbox/";
$loginFile = "$currentWidgetPath"."loginbox.php";
$logoutFile = "logout.php?folder=".$dirprefix."&user=".$user."";

// if form is sent
if(isset($_POST['user'])) {
// create new user object
$user = new YAWK\user();
  if(isset($_POST['user']))
  { // if username is set
  	 // call login method 
    if($user->login($db, $_POST['user'],$_POST['password'])) {
		 if(isset($_SESSION['username']) && $_SESSION['logged_in'] == true)
		 {	// user is logged in, redirect to welcome controller
			 \YAWK\sys::setTimeout("welcome.html",0);
			 exit;
		 }
		 else
		 {	// user is not logged in...
			 \YAWK\alert::draw("danger", "Error!", "Obviously you are not correctly logged in. Please try again.", "index.html", 2800);
			 exit;
		 }
    }
    else // login method returns FALSE
	{	 // username or password is wrong
		\YAWK\alert::draw("warning", "Warning", "Username or Password not correct. Please try again.", "welcome.html", 2800);
		exit;
	}
  }
  else
  {	  // username is not set, draw loginbox
      echo \YAWK\user::drawLoginBox("","");
  }
}

// if user logged in, draw logout link
if(isset($_SESSION['username']) && $_SESSION['logged_in'] == true)
	{
		echo "<form name=\"login\" class=\"navbar-form text-center\" role=\"form\">
		Hallo "; echo"<a href=\"welcome.html\" target=\"_self\">";echo YAWK\sys::getCurrentUserName();echo"</a>";
		echo"!&nbsp;&nbsp;<a href=\"welcome.html\" target=\"_self\"><i class=\"glyphicon glyphicon-home\"></i></a>&nbsp;&nbsp;
		<a href=\"".$currentWidgetPath."".$logoutFile."\" class=\"btn btn-danger active\" target_\"self\">logout</a></form>";
}

else { 
// get widget settings and draw login box
if (isset($wID))
{		$w_value = "";
		/* get widget settings */    
		/* ESSENTIAL TO GET WIDGETS WORK PROPERLY */
	    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$wID."'
	                        AND activated = '1'");
	    while($row = mysqli_fetch_row($res)) {
	      $w_property = $row[1];   
	      $w_value = $row[2];
	      $w_widgetType = $row[3];
	      $w_activated = $row[4];
	      }
}

		/* LOAD PROPERTY LOGINBUTTON (text) */
		if (isset($w_property)){
			if ($w_property === "buttontitle") {
				$buttoncode = 	$w_value;	
			} 
			else { 
				$buttoncode="Login"; }
		}
		else { $buttoncode="Login"; } // default setting for content include
		/* end load property loginbuttontext */
	 
	// draw login box
    echo \YAWK\user::drawLoginBox("","");
	  }
