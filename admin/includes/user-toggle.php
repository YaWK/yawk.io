<?php
    // username is not set
    if (!isset($user))
    {   // create new object
        $user = new YAWK\user();
    }
    if (isset($_GET['blocked']))
    {   // set user obj property
        $user->blocked = $_GET['blocked'];
    }
    if (isset($_GET['uid']))
    {   // set user id
        $user->id = $_GET['uid'];
    }
    if ($user->blocked === '1')
    {   // user is not blocked
        $user->blocked = 0;
    }
	else
    {   // set user status to blocked
		$user->blocked = 1;
	}

// now toggle user status
if($user->toggleOffline($db, $user->id, $user->blocked))
  {   // successful
      \YAWK\backend::setTimeout("index.php?page=users",0);
  }
  else
  {   // throw error
  	  print \YAWK\alert::draw("danger", "Error!", "Could not toggle user status.", "page=users","2800");
  }
