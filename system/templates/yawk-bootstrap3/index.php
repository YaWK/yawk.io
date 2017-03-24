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
 <meta name="author" content="<?php echo YAWK\settings::getSetting($db, "siteauthor"); ?>">
 <meta name="keywords" content="<?php echo YAWK\settings::getSetting($db, "globalmetakeywords"); ?>">
 <meta name="description" content="<?php echo YAWK\settings::getSetting($db, "globalmetatext"); ?>">
 <meta charset="utf-8">
 <meta http-equiv="imagetoolbar" content="no">
 <meta name="google-site-verification" content="x557vK7Psu-reaTe6WOfjYXSKhCxUmfkRiX1sOKlTdA">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <!-- apple touch icons -->
 <link rel="apple-touch-icon" sizes="120x120" href="media/images/apple-touch-icon-120x120-precomposed.png">
 <link rel="apple-touch-icon" sizes="152x152" href="media/images/apple-touch-icon-152x152-precomposed.png">
    <!-- import font awesome -->
    <link rel="stylesheet" href="system/engines/font-awesome/css/font-awesome.min.css" type="text/css" media="all">
    <!-- import animate.css -->
    <!-- <link rel="stylesheet" href="system/engines/animateCSS/animate.min.css" type="text/css" media="all"> -->
    <!-- Bootstrap core CSS -->
    <link href="system/engines/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Own Template Settings: Bootstrap core CSS override -->
    <link href="system/templates/<?php echo $template; ?>/css/settings.min.css" rel="stylesheet">
    <!-- CUSTOM Template Override: custom.CSS -->
    <link href="system/templates/<?php echo $template; ?>/css/custom.min.css" rel="stylesheet">
    <!-- import jquery 1.11.3 -->
    <script src="system/engines/jquery/jquery-1.11.3.min.js"></script>
    <!-- validation plugin
    <script src="system/engines/jquery/jquery.validate.min.js"></script> -->
    <!-- jQuery UI -->
    <script src="system/engines/jquery/jquery-ui.min.js"></script>
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

    <!-- JS <noscript> tag -->
    <!-- <noscript><br><br><h2 style="text-align: center;">This page requires a modern browser with javascript. <br><small>Please activate Javascript or use a better browser.</small></h2></noscript> -->
<!-- gfonts -->
<?php
// include additional html header stuff & local meta tags
\YAWK\sys::includeHeader($db);
// load active google font code
\YAWK\template::outputActivegFont($db);
// load position stats (0|1)
$positions = \YAWK\template::getPositionStatesArray($db);
// load position indicators
$indicators = \YAWK\template::getPositionIndicatorStatusArray($db);

?>
<!-- /gfonts -->
  </head>
  <body style="<?php echo YAWK\template::getActivegfont($db, "", "text-gfont"); ?>" ondragstart="return false">

  <!-- LAYOUT START -->

  <div class="container-fluid">
      <div class="row">
      <?php
        // POSITION: outerTop
        \YAWK\template::getPositionDivBox($db, "outerTop", 1, "col-md-12", $positions, $indicators);
      ?>
      </div>
      <div class="row text-center">
          <?php
              // POSITION: outerLeft
              \YAWK\template::getPositionDivBox($db, "outerLeft", 0, "col-md-2", $positions, $indicators);
          ?>
          <!-- <div class="col-md-2 posbox" id="pos_outerLeft" style="height: 630px; margin-bottom:5px; text-align: center;">&laquo;outerLeft&raquo;</div> -->
          <?php
          if ($positions['pos-outerLeft-enabled'] === "1" && ($positions['pos-outerRight-enabled'] === "1"))
          {
              $col = "col-md-8";
          }
          else if ($positions['pos-outerLeft-enabled'] === "0" && ($positions['pos-outerRight-enabled'] === "1")
          ||      ($positions['pos-outerLeft-enabled'] === "1" && ($positions['pos-outerRight-enabled'] === "0")))
          {
            $col = "col-md-10";
          }
          else if ($positions['pos-outerLeft-enabled'] === "0" && ($positions['pos-outerRight-enabled'] === "0"))
              {
                  $col = "col-md-12";
              }
          ?>
          <div class="<?php echo $col; ?>">
              <div class="row">
                  <?php
                  // POSITION: intro
                  \YAWK\template::getPositionDivBox($db, "intro", 1, "col-md-12", $positions, $indicators);

                  // POSITION: globalmenu
                  \YAWK\template::getPositionDivBox($db, "globalmenu", 1, "col-md-12", $positions, $indicators);

                  // POSITION: top
                  \YAWK\template::getPositionDivBox($db, "top", 1, "col-md-12", $positions, $indicators);
                  ?>
              </div>
              <div class="row">
                  <?php
                  // POSITION: leftMenu
                  \YAWK\template::getPositionDivBox($db, "leftMenu", 0, "col-md-2", $positions, $indicators);
                  ?>
                  <!-- <div class="col-md-2 posbox" id="pos_outerLeft" style="height: 630px; margin-bottom:5px; text-align: center;">&laquo;outerLeft&raquo;</div> -->
                  <?php
                  if ($positions['pos-leftMenu-enabled'] === "1" && ($positions['pos-rightMenu-enabled'] === "1"))
                  {
                      $col = "col-md-8";
                  }
                  else if ($positions['pos-leftMenu-enabled'] === "0" && ($positions['pos-rightMenu-enabled'] === "1")
                      ||      ($positions['pos-leftMenu-enabled'] === "1" && ($positions['pos-rightMenu-enabled'] === "0")))
                  {
                      $col = "col-md-10";
                  }
                  else if ($positions['pos-leftMenu-enabled'] === "0" && ($positions['pos-rightMenu-enabled'] === "0"))
                  {
                      $col = "col-md-12";
                  }
                  ?>
                  <div class="<?php echo $col; ?>">
                  <!-- <div class="col-md-2 posbox" id="pos_leftMenu" style="height: 410px; margin-bottom:5px; text-align: center;">&laquo;leftMenu&raquo;</div> -->
                  <!-- <div class="col-md-8" style="height: auto; margin-bottom:5px; text-align: center;"> -->
                      <div class="row">
                          <?php
                          // POSITION: mainTop
                          \YAWK\template::getPositionDivBox($db, "mainTop", 1, "col-md-12", $positions, $indicators);
                          ?>
                          <!-- <div class="col-md-12 posbox" id="pos_mainTop" style="height: auto; margin-bottom:5px; text-align: center;">&laquo;mainTop&raquo;</div> -->
                      </div>
                      <div class="row">
                          <?php
                          if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, "mainTopLeft", 0, "col-md-4", $positions, $indicators);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainTopCenter", 0, "col-md-4", $positions, $indicators);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainTopRight", 0, "col-md-4", $positions, $indicators);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "0") && ($positions['pos-mainTopRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, "mainTopLeft", 0, "col-md-12", $positions, $indicators);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "0" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainTopCenter", 0, "col-md-12", $positions, $indicators);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "0" && ($positions['pos-mainTopCenter-enabled'] === "0") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainTopRight", 0, "col-md-12", $positions, $indicators);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, "mainTopLeft", 0, "col-md-6", $positions, $indicators);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainTopCenter", 0, "col-md-6", $positions, $indicators);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "0" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainTopCenter", 0, "col-md-6", $positions, $indicators);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainTopRight", 0, "col-md-6", $positions, $indicators);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "0") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainTopLeft", 0, "col-md-6", $positions, $indicators);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainTopRight", 0, "col-md-6", $positions, $indicators);
                          }
                          ?>
                      </div>

                      <div class="row">
                          <?php
                          // POSITION: main
                          \YAWK\template::getPositionDivBox($db, "main", 0, "col-md-12", $positions, $indicators);
                          ?>
                      </div>
                      <div class="row">
                          <?php
                          // POSITION: main
                          \YAWK\template::getPositionDivBox($db, "mainBottom", 0, "col-md-12", $positions, $indicators);
                          ?>
                      </div>
                      <div class="row">

                          <?php
                          if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainBottomLeft
                              \YAWK\template::getPositionDivBox($db, "mainBottomLeft", 0, "col-md-4", $positions, $indicators);
                              // POSITION: mainBottomCenter
                              \YAWK\template::getPositionDivBox($db, "mainBottomCenter", 0, "col-md-4", $positions, $indicators);
                              // POSITION: mainBottomRight
                              \YAWK\template::getPositionDivBox($db, "mainBottomRight", 0, "col-md-4", $positions, $indicators);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "0") && ($positions['pos-mainBottomRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, "mainBottomLeft", 0, "col-md-12", $positions, $indicators);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "0" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainBottomCenter", 0, "col-md-12", $positions, $indicators);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "0" && ($positions['pos-mainBottomCenter-enabled'] === "0") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainBottomRight", 0, "col-md-12", $positions, $indicators);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, "mainBottomLeft", 0, "col-md-6", $positions, $indicators);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainBottomCenter", 0, "col-md-6", $positions, $indicators);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "0" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainBottomCenter", 0, "col-md-6", $positions, $indicators);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainBottomRight", 0, "col-md-6", $positions, $indicators);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "0") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, "mainBottomLeft", 0, "col-md-6", $positions, $indicators);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, "mainBottomRight", 0, "col-md-6", $positions, $indicators);
                          }
                          ?>
                      </div>
                      <div class="row">
                          <div class="col-md-12 posbox" id="pos_mainFooter" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;mainFooter&raquo;</div>
                      </div>
                      <div class="row">
                          <div class="col-md-4 posbox" id="pos_mainFooterLeft" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;mainFooterLeft&raquo;</div>
                          <div class="col-md-4 posbox" id="pos_mainFooterCenter" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;mainFooterCenter&raquo;</div>
                          <div class="col-md-4 posbox" id="pos_mainFooterRight" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;mainFooterRight&raquo;</div>
                      </div>
                  </div>
                  <?php
                  // POSITION: outerLeft
                  \YAWK\template::getPositionDivBox($db, "rightMenu", 0, "col-md-2", $positions, $indicators);
                  ?>
                  <!-- <div class="col-md-2 posbox" id="pos_rightMenu" style="height: 410px; margin-bottom:5px; text-align: center;">&laquo;rightMenu&raquo;</div> -->
              </div>

              <div class="row">
                  <div class="col-md-12 posbox" id="pos_footer" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;footer&raquo;</div>
              </div>
              <div class="row">
                  <div class="col-md-12 posbox" id="pos_hiddenToolbar" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;hiddenToolbar&raquo;</div>
              </div>
              <div class="row">
                  <div class="col-md-12 posbox" id="pos_debug" style="height: 30px; margin-bottom:5px; text-align: center;">&laquo;debug&raquo;</div>
              </div>
          </div>

          <?php
          // POSITION: outerRight
          \YAWK\template::getPositionDivBox($db, "outerRight", 0, "col-md-2", $positions, $indicators);
          ?>

      </div>

      <div class="row text-center">
          <div class="col-md-12 posbox" id="pos_outerBottom" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center;">&laquo;outerBottom&raquo;</div>
      </div>
  </div>

  <!-- LAYOUT END -->



  <?php
  // :INTRO before everything else, on top of page
  if ($positions['pos-outerTop-enabled'] === "1")
  {
   //   echo "<div class=\"pos-outerTop\" id=\"pos-outerTop\">";
   //   echo YAWK\template::setPosition($db, "outerTop-pos");
   //   echo "</div>";
  }

  // :INTRO before everything else, on top of page
  if ($positions['pos-intro-enabled'] === "1")
  {
    // echo "<div class=\"pos-intro\" id=\"pos-intro\">";
    // echo YAWK\template::setPosition($db, "intro-pos");
    // echo "</div>";
  }
  ?>

  <!-- :GLOBALMENU -->
    <div style="<?php echo YAWK\template::getActivegfont($db, "", "menu-gfont"); ?>">
    <?php // echo YAWK\template::setPosition($db, "globalmenu-pos"); ?>  <!-- GLOBALMENU -->
      <!--/ END NAV -->
    </div>

      <!-- :TOP -->
      <div>
          <?php echo YAWK\template::setPosition($db, "top-pos"); ?>
      </div>

          <div class="col-md-2" id="left">
              <br><br>
              <br><br>
                <?php echo YAWK\template::setPosition($db, "leftMenu-pos"); ?>
          </div>

          <div class="col-md-8" id="middle">
              <br><br>
              <!-- :MAIN component for a primary marketing message or call to action -->
              <div class="well">
                  <?php echo YAWK\template::setPosition($db, "mainTop-pos"); ?>
                  <!-- main bottom, 3 cols -->
                  <div class="row">
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainTopLeft-pos"); ?>
                      </div>
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainTopCenter-pos"); ?>
                      </div>
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainTopRight-pos"); ?>
                      </div>
                  </div>

                  <?php echo YAWK\template::setPosition($db, "main-pos"); ?>
                  <?php echo YAWK\template::setPosition($db, "mainBottom-pos"); ?>

                  <!-- main bottom, 3 cols -->
                  <div class="row">
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainBottomLeft-pos"); ?>
                      </div>
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainBottomCenter-pos"); ?>
                      </div>
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainBottomRight-pos"); ?>
                      </div>
                  </div>

                    <?php echo YAWK\template::setPosition($db, "mainFooter-pos"); ?>

                  <!-- main footer, 3 cols -->
                  <div class="row">
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainFooterLeft-pos"); ?>
                      </div>
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainFooterCenter-pos"); ?>
                      </div>
                      <div class="col-md-4">
                          <?php echo YAWK\template::setPosition($db, "mainFooterRight-pos"); ?>
                      </div>
                  </div>
              </div>
          </div>

      <div class="col-md-2" id="right">
          <br><br>
          <br><br>
            <?php echo YAWK\template::setPosition($db, "rightMenu-pos"); ?>
      </div>

      <!-- :BOTTOM component for a primary marketing message or call to action -->
      <div>
          <?php echo YAWK\template::setPosition($db, "bottom-pos"); ?>

      </div>

      <!-- :FOOTER component for a primary marketing message or call to action -->
      <div>
          <?php echo YAWK\template::setPosition($db, "footer-pos"); ?>

      </div>

      <!-- :HIDDENTOOLBAR component for a primary marketing message or call to action -->
      <div class="hidden">
          <?php echo YAWK\template::setPosition($db, "hiddentoolbar-pos"); ?>
      </div>

      <!-- :DEBUG component for a primary marketing message or call to action -->
      <div>
          <?php echo YAWK\template::setPosition($db, "debug-pos"); ?>
      </div>

      <script>
          $(document).ready(function(){
             // $("#mainPos").addClass("slide");

              // Add smooth scrolling to all links in navbar + footer link
              $(".submenu a, a[href='#sicherheit']").on('click', function(event) {
                  // Prevent default anchor click behavior
                  event.preventDefault();
                  // Store hash
                  var hash = this.hash;
                  // Using jQuery's animate() method to add smooth page scroll
                  // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                  $('html, body').animate({
                      scrollTop: $(hash).offset().top
                  }, 900, function(){
                      // Add hash (#) to URL when done scrolling (default click behavior)
                      window.location.hash = hash;
                  });
              });

              // Slide in elements on scroll
              $(window).scroll(function() {
                  $(".slideanim").each(function(){
                      var pos = $(this).offset().top;

                      var winTop = $(window).scrollTop();
                      if (pos < winTop + 600) {
                          $(this).addClass("slide");
                      }
                  });
              });
          })
      </script>

 </body>
</html>