<?php
session_start();
include '../../classes/settings.php';
include '../../classes/alert.php';
include '../../classes/backend.php';
include '../../classes/template.php';
/* include core files */
include("../../classes/db.php");
/* set database object */
if (!isset($db)) {
    $db = new \YAWK\db();
}

   $dirprefix="$_GET[folder]"."/";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Logout</title>

    <!-- Bootstrap core CSS -->
    <link href="../../engines/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php
        // load active google font code
        \YAWK\template::outputActivegFont($db);
    ?>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  <style type="text/css">

    html, body { font-family: 'Raleway', sans-serif; color:#fff; text-shadow: 1px 1px 1px #2e2e2e;
    background-color: #2e2e2e;
   background-image: url(media/images/bg1920.jpg);
   background-repeat:no-repeat;  }
    .formtag { font-size: 10px; font-weight: bold;  }
      a:link {color:#CCCCCC}
      a:visited {color:#4E4E4E}
      a:hover {color:#999999}
      a:active {color:#2a2a2a}
    h1 { font-family:'Oswald', sans-serif; color:#f9cd88;  }

  </style>
  </head>

  <body>
  hallo....
<?php $host = \YAWK\settings::getSetting($db, "host"); ?>
    <?php// echo YAWK\template::setPosition("globalmenu-pos"); ?>  <!-- GLOBALMENU -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $host; ?>"><?php echo $host; ?></a>
        </div>
        <div class="navbar-collapse collapse">
        <br>
        Danke - bis zum n&auml;chsten mal!
        </div><!--/.navbar-collapse -->
      </div>
    </div>

<?php
  	// set user offline in db
   	if (!$res=$db->query("UPDATE {users}
  									 SET online = '0',
  									     logged_in = '0'
   							         WHERE username = '".$_GET['user']."'")) {
		 \YAWK\alert::draw("warning", "Achtung:", "Userstatus konnte nicht gesetzt werden.", "", 5000);
		 // $fehler = in var f�r fehlerklasse speichern?             	
   	} 
session_destroy();
YAWK\backend::setTimeout("$host","1600");
?>

<noscript>
Im Browser muss javascript aktiviert sein, um die Seite richtig nutzen zu k&ouml;nnen.
<meta http-equiv="refresh" content="1; URL=<?php echo $host; ?>">
</noscript>

</body>
</html>

