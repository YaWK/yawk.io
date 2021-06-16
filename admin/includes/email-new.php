<?php

use YAWK\backend;
use YAWK\db;
use YAWK\email;
use YAWK\language;

if (!isset($db))
{   // create database object
    $db = new db();
}
if (!isset($lang))
{   // create language object
    $lang = new language();
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
<!-- Content Wrapper. Contains page content -->
<div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['EMAIL'], $lang['EMAILNEW_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=users\" title=\"Users\"> $lang[USERS]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";

// if form is sent
  if(isset($_POST['send']))
  {
    $email_from = YAWK\settings::getSetting($db, 'admin_email');
    $email_to = $db->quote($_POST['email_to']);
	$email_cc = $db->quote($_POST['email_cc']);
	$email_subject = $db->quote($_POST['email_subject']);
    $email_message = $db->quote($_POST['email_message']);
    email::sendEmail($email_from, $email_to, $email_cc, $email_subject, $email_message);
  }
  else
  {   // prepare vars + draw input form...
	  if (isset($_GET['user'])) {
		// fetch users email adress
		$user = $_GET['user'];
		$email_to = \YAWK\user::getUserEmail($db, $user);
        $email_from = YAWK\settings::getSetting($db, 'admin_email');
	  	}
	  	else
        {   // username is not set
            $user = "";
        }
	  	if (!isset($email_to))
        {   // email_to is empty
	  	    $email_to = "";
	  	}
        if (!isset($email_from))
        {   // email_from is empty
            $email_from = "";
        }
  }
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header"><h3 class="box-title"><?php echo $lang['EMAIL']." ".$lang['EMAILNEW_SUBTEXT']; ?></h3></div>
            <div class="box-body">
                <form action="index.php?page=email-new" class="form" method="POST">
                        <label for="email_from"><?php echo $lang['FROM']; ?></label>
                        <input id="email_from"
                               type="text"
                               class="form-control"
                               name="email_from"
                               size="15"
                               placeholder="<?php echo $lang['FROM']; ?>:"
                               value="<?php echo $email_from; ?>"
                               maxlength="64">

                        <label for="email_to"><?php echo $lang['TO']; ?>:</label>
                        <input id="email_to"
                               type="text"
                               class="form-control"
                               name="email_to"
                               size="15"
                               placeholder="<?php echo $lang['TO']; ?>:"
                               value="<?php echo $email_to; ?>"
                               maxlength="64">
                        <label for="email_subject"><?php echo $lang['SUBJECT']; ?>:</label>
                        <input id="email_subject"
                               type="text"
                               class="form-control"
                               name="email_subject"
                               size="15"
                               placeholder="<?php echo $lang['SUBJECT']; ?>"
                               maxlength="64">
                        <label for="email_message"><?php echo $lang['MESSAGE']; ?>:</label>
                        <textarea id="email_message"
                                  name="email_message"
                                  class="form-control"
                                  cols="64"
                                  rows="15"><?php echo $lang['MESSAGE']; ?>
                        </textarea><br>
                        <button type="submit"
                                name="send"
                                class="btn btn-success pull-right"><i class="fa fa-envelope-o"></i>
                                &nbsp; <?php echo $lang['EMAIL_SEND']; ?>&nbsp;<?php echo $lang['TO']; ?>&nbsp;<?php echo $user; ?></button>
                </form>
            </div>
        </div>

    </div>
    <div class="col-md-6">&nbsp;</div>
</div>