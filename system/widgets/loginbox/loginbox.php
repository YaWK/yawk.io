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
if(isset($_POST['user']))
{
// create new user object
$user = new YAWK\user();
  if(isset($_POST['user']))
  { // if username is set
  	 // call login method 
    if($user->login($db, $_POST['user'],$_POST['password']))
    {
		 if(isset($_SESSION['username']) && $_SESSION['logged_in'] == true)
		 {	// user is logged in, redirect to welcome page
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
		echo "<form name=\"login\" class=\"navbar-form text-center\" style=\"text-align: inherit;\" role=\"form\">
		Hallo "; echo"<a href=\"welcome.html\" target=\"_self\">";echo YAWK\sys::getCurrentUserName();echo"</a>";
		echo"!&nbsp;&nbsp;<a href=\"welcome.html\" target=\"_self\"><i class=\"glyphicon glyphicon-home\"></i></a>&nbsp;&nbsp;
		<a href=\"".$currentWidgetPath."".$logoutFile."\" class=\"btn btn-danger active\" target_\"self\">logout</a></form>";
}

else
    {   // user is NOT logged in
        // get widget settings and draw login box
    // $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
    if (isset($_GET['widgetID']))
    {
        // widget ID
        $widgetID = $_GET['widgetID'];

        // get widget settings from db
        $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
        while($row = mysqli_fetch_assoc($res))
        {   // set widget properties and values into vars
            $w_property = $row['property'];
            $w_value = $row['value'];
            $w_widgetType = $row['widgetType'];
            $w_activated = $row['activated'];
            /* end of get widget properties */

            /* filter and load those widget properties */
            if (isset($w_property)){
                switch($w_property)
                {
                    /* url of the video to stream */
                    case 'loginboxButtonText';
                        $buttonText = $w_value;
                        break;
                }
            } /* END LOAD PROPERTIES */
        } // end while fetch row (fetch widget settings)
    }

    // if a heading is set and not empty
    if (isset($heading) && (!empty($heading)))
    {   // add a h1 tag to heading string
        $heading = "$heading";

        // if subtext is set, add <small> subtext to string
        if (isset($subtext) && (!empty($subtext)))
        {   // build a headline with heading and subtext
            $subtext = "<small>$subtext</small>";
            $headline = "<h1>$heading&nbsp;"."$subtext</h1>";
        }
        else
        {   // build just a headline - without subtext
            $headline = "<h1>$heading</h1>";    // draw just the heading
        }
    }
    else
    {   // leave empty if it's not set
        $headline = '';
    }

    // draw headline, if set
    echo $headline;
    // draw login box
    echo \YAWK\user::drawLoginBox("","");
}
