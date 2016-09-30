<!DOCTYPE html>
<html lang="de">
<head>
<?php /* INDEX.PHP - UNIVERSAL TEMPLATE 1.0 */
/*  template positions from top to bottom
  # globalmenu
  # top
  # main
  # bottom
  # footer
  # hiddentoolbar
  # debug
  db-positions:
  globalmenu:top:main:bottom:footer:hiddentoolbar:debug
*/
if (isset($_GET['template']) && (!empty($template)))
{
    $template = $_GET['template'];
}
else
    {
       // $template = YAWK\template::getCurrentTemplateNameById($db, "");
        $template = $templateName;
    }
?>
 <!-- To ensure proper rendering and touch zooming on phones and tablets -->
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <!-- import meta tags -->
 <meta name="author" content="<?php echo YAWK\settings::getSetting($db, "siteauthor"); ?>" />
 <meta name="keywords" content="<?php echo YAWK\settings::getSetting($db, "globalmetakeywords"); ?>" />
 <meta name="description" content="<?php echo YAWK\settings::getSetting($db, "globalmetatext"); ?>" />
 <meta charset="utf-8">
 <meta http-equiv="imagetoolbar" content="no">
 <meta name="google-site-verification" content="x557vK7Psu-reaTe6WOfjYXSKhCxUmfkRiX1sOKlTdA" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <!-- apple touch icons -->
 <link rel="apple-touch-icon" sizes="120x120" href="media/images/apple-touch-icon-120x120-precomposed.png" />
 <link rel="apple-touch-icon" sizes="152x152" href="media/images/apple-touch-icon-152x152-precomposed.png" />
    <!-- import font awesome -->
    <link rel="stylesheet" href="system/engines/font-awesome/css/font-awesome.min.css" type="text/css" media="all" />
    <!-- import animate.css -->
    <!-- <link rel="stylesheet" href="system/engines/animateCSS/animate.min.css" type="text/css" media="all" /> -->
    <!-- Bootstrap core CSS -->
    <link href="system/engines/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Own Template Settings: Bootstrap core CSS override -->
    <link href="system/templates/<?php echo $template; ?>/css/settings.min.css" rel="stylesheet">
    <!-- CUSTOM Template Override: custom.CSS -->
    <link href="system/templates/<?php echo $template; ?>/css/custom.min.css" rel="stylesheet">
    <!-- import jquery 1.11.3 -->
    <script src="system/engines/jquery/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]>
    <script src="system/engines/jquery/html5shiv.min.js"></script>
    <script src="system/engines/jquery/1.3.0-respond.min.js"></script>
    <![endif]-->
    <!-- import custom js -->
    <script src="system/templates/<?php echo $template; ?>/js/custom.min.js"></script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Boostrap jQuery Plugins -->
    <script src="system/engines/bootstrap/dist/js/bootstrap.min.js"></script>
<noscript><br><br><h2 style="text-align: center;">Diese Seite erfordert einen modernen Browser. <br><small>Bitte aktualisiere Deinen Browser und aktiviere JavaScript.</small></h2></noscript>
<!-- gfonts -->
<?PHP
// include additional html header stuff & local meta tags
\YAWK\sys::includeHeader($db);
// load active google font code
\YAWK\template::outputActivegFont($db);
?>
<!-- /gfonts -->
  </head>
  <body style="<?PHP echo YAWK\template::getActivegfont($db, "", "text-gfont"); ?>" ondragstart="return false">

  <div class="container">
      <!-- YAWK NAV -->
    <div style="<?PHP echo YAWK\template::getActivegfont($db, "", "menu-gfont"); ?>">
    <?php echo YAWK\template::setPosition($db, "globalmenu-pos"); ?>  <!-- GLOBALMENU -->
      <!--/ END NAV -->
    </div>
  </div>

  <div class="container">
      <div id="bodyFX">
  <?php /*
  if (isset($_GET['include']) && $_GET['include'] == 'startseite') {
    echo "
  <div id=\"top-pos\" class=\"jumbotron\">";
      echo YAWK\template::setPosition($db, "top-pos");
    echo"
  </div>";
  } */
  ?>
      <!-- :MAIN component for a primary marketing message or call to action -->
      <div class="well" id="main-pos">
      <?php echo YAWK\template::setPosition($db, "main-pos"); ?>
      </div>

      <?php /*
      if (isset($_GET['include']) && $_GET['include'] == 'startseite') {
          echo "
            <div class=\"jumbotron-dark\">";
          echo YAWK\template::setPosition($db, "add-pos");
          echo"<br>
            </div>";
      }
      if (isset($_GET['include']) && $_GET['include'] == 'startseite') {
          echo "
          <div class=\"well\">";
           echo YAWK\template::setPosition($db, "add2-pos");
           echo"
          </div>";
          }
          ?>

      <!-- :BOTTOM component for a primary marketing message or call to action -->
      <div class="well">
      <?php echo YAWK\template::setPosition($db, "bottom-pos"); ?>
      </div>

          <?php
          if (isset($_GET['include']) && $_GET['include'] == 'startseite') {
          echo "
          <!-- :BOTTOM 2 component for a primary marketing message or call to action -->
            <div class=\"jumbotron-dark\">";
              echo YAWK\template::setPosition($db, "bottom2-pos");
              echo"
            </div>";
              echo "
          <!-- :BOTTOM 3 component for a primary marketing message or call to action -->
            <div class=\"jumbotron-dark\">";
              echo YAWK\template::setPosition($db, "bottom3-pos");
              echo"
            </div>";
          }
 */
          ?>


      <div class="well" id="footer-copyright">
      <p class="pull-right">
          <small>
              <i class="fa fa-copyright"></i> <?PHP print date("Y"); ?> <?php echo YAWK\settings::getSetting($db, "host"); ?>
          </small>
      </p>
          <br>
      <?php echo YAWK\template::setPosition($db, "footer-pos"); ?>
      </div>

     <!--  <div class="footer-bg">
      </div> -->

</div>
  </div> <!-- /container -->
    <div class="container" style="margin-bottom:450px;">
    <?php echo YAWK\template::setPosition($db, "debug-pos"); ?>
    </div>

 </body>
</html>