<?PHP
  if (!isset($user))
  {   // generate new user object
      $user = new YAWK\user();
  }
  /* draw Title on top */
  \YAWK\backend::drawContentWrapper();
  /* if delete signal is sent */
if (isset($_GET['delete']))
{
    if($_GET['delete'] === "true") {
      if (isset($_GET['user']))
      {   // username is set, check forbidden names
          if ($_GET['user'] === 'admin' OR $_GET['user'] === 'root' OR $_GET['user'] === 'administrator')
          {
              print \YAWK\alert::draw("danger", "Achtung:", "Es ist nicht m&ouml;glich, den Root-User (admin) zu l&ouml;schen.","page=users","4800");
              exit;
          }
          // delete user
          if($user->delete($db, $_GET['user']))
          {   // success
              print \YAWK\alert::draw("success", "Erfolg!", "Der User <strong>".$_GET['user']."</strong> wurde gel&ouml;scht!","page=users","2000");
          }
          else
          {   // throw error
              print \YAWK\alert::draw("danger", "Fehler!", "Der User <strong>".$_GET['user']."</strong> konnte nicht gel&ouml;scht werden!","page=users","5000");
          }
      }
      else
      {
          print \YAWK\alert::draw("danger", "Error", "You shall not manipulate vars...","page=users","8000");
          exit;
      }
    // draw success or error message
  }
}
  else
  {
      print "
        <div class=\"text-center\">
          <p>Soll der Benutzer <strong>$_GET[user]</strong> unwideruflich gel&ouml;scht werden?</p>
          <a class=\"btn btn-default\" href=\"index.php?page=users\">Abbrechen</a>
          <a class=\"btn btn-warning\" href=\"index.php?page=user-delete&user=$_GET[user]&delete=true\">
            <i class=\"fa fa-trash-o\"></i>&nbsp; Benutzer l&ouml;schen
          </a>
        </div>";
  }