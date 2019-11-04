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
/** @vars
 *  these vars are declared in yourdomain/index.php before inclusion of this document
 *  $template               // template object
 *  $controller             // controller object
 *  $page                   // page object
 *  $user                   // user object
 *  $stats                  // stats object
 */
/* db object */
/** @var $db \YAWK\db */
/* language object */
/** @var $lang \YAWK\language */
/* template object */
/** @var $template \YAWK\template */
// \YAWK\sys::outputObjects($template, $controller, $page, $user, $stats);
?>
<!-- To ensure proper rendering and touch zooming on phones and tablets -->
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- import meta tags -->
 <meta name="author" content="<?php echo YAWK\settings::getSetting($db, "siteauthor"); ?>">
 <meta name="keywords" content="<?php echo YAWK\settings::getSetting($db, "globalmetakeywords"); ?>">
 <meta name="description" content="<?php echo YAWK\settings::getSetting($db, "globalmetatext"); ?>">
<!-- favicons -->
 <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
 <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
 <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
 <link rel="manifest" href="/site.webmanifest">
 <meta name="msapplication-TileColor" content="#ffffff">
 <meta name="theme-color" content="#ffffff">
<?php
// get current host
$host = \YAWK\sys::addTrailingSlash(\YAWK\settings::getSetting($db, "host"));
// include additional html header stuff & local meta tags
\YAWK\sys::includeHeader($db, $host);
// load active google font code
\YAWK\template::loadGoogleFonts($db);
// load position stats (0|1)
$positions = \YAWK\template::getPositionStatesArray($db, $template->id);
// load position indicators
$indicators = \YAWK\template::getPositionIndicatorStatusArray($db, $template->id);
// load active assets for this template
$template->loadActiveAssets($db, $template->id, $host);
?>

<!-- SETTINGS.MIN.CSS YaWK template settings: Bootstrap core CSS override -->
<link rel="stylesheet" type="text/css" href="system/templates/<?php echo $template->name; ?>/css/settings.min.css">
<!-- CUSTOM.MIN.CSS User defined CSS Rules -->
<link rel="stylesheet" type="text/css" href="system/templates/<?php echo $template->name; ?>/css/custom.min.css">

<!--[if lt IE 9]>
<script src="system/engines/jquery/html5shiv.min.js"></script>
<script src="system/engines/jquery/1.3.0-respond.min.js"></script>
<![endif]-->

<!-- import yawk app: custom js -->
<script src="system/templates/<?php echo $template->name; ?>/js/custom.min.js"></script>
</head>

<body style="<?php echo YAWK\template::getActiveBodyFont($db); ?>" ondragstart="return false" id="home">

<?php
$col = '';
// \YAWK\sys::outputObjects($template, $controller, $page, $user, $stats);
// exit;
?>
  <!-- LAYOUT START -->
  <div class="container-fluid">
      <div class="row">
      <?php
        // POSITION: outerTop
        \YAWK\template::getPositionDivBox($db, $lang, "outerTop", 1, "col-md-12", $positions, $indicators, $template);
      ?>
      </div>
      <div class="row">
          <?php
              // POSITION: outerLeft
              \YAWK\template::getPositionDivBox($db, $lang, "outerLeft", 0, "col-md-2", $positions, $indicators, $template);
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
                  \YAWK\template::getPositionDivBox($db, $lang, "intro", 1, "col-md-12", $positions, $indicators, $template);

                  // POSITION: globalmenu
                  \YAWK\template::getPositionDivBox($db, $lang, "globalmenu", 1, "col-md-12", $positions, $indicators, $template);

                  // POSITION: top
                  \YAWK\template::getPositionDivBox($db, $lang, "top", 1, "col-md-12", $positions, $indicators, $template);
                  ?>
              </div>
              <div class="row">
                  <?php
                  // POSITION: leftMenu
                  \YAWK\template::getPositionDivBox($db, $lang, "leftMenu", 0, "col-md-2", $positions, $indicators, $template);
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
                          \YAWK\template::getPositionDivBox($db, $lang, "mainTop", 1, "col-md-12", $positions, $indicators, $template);
                          ?>
                          <!-- <div class="col-md-12 posbox" id="pos_mainTop" style="height: auto; margin-bottom:5px; text-align: center;">&laquo;mainTop&raquo;</div> -->
                      </div>
                      <div class="row">
                          <?php
                          if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopLeft", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopCenter", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopRight", 0, "col-md-4", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "0") && ($positions['pos-mainTopRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopLeft", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "0" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopCenter", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "0" && ($positions['pos-mainTopCenter-enabled'] === "0") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopRight", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopCenter", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "0" && ($positions['pos-mainTopCenter-enabled'] === "1") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopCenter", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainTopLeft-enabled'] === "1" && ($positions['pos-mainTopCenter-enabled'] === "0") && ($positions['pos-mainTopRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainTopRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          ?>
                      </div>
                      <div class="row">
                          <?php
                          if ($positions['pos-mainLeft-enabled'] === "1" && ($positions['pos-main-enabled'] === "1") && ($positions['pos-mainRight-enabled'] === "1"))
                          {
                              // POSITION: mainLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainLeft", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: main
                              \YAWK\template::getPositionDivBox($db, $lang, "main", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainRight", 0, "col-md-4", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainLeft-enabled'] === "1" && ($positions['pos-main-enabled'] === "0") && ($positions['pos-mainRight-enabled'] === "0"))
                          {
                              // POSITION: mainLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainLeft", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainLeft-enabled'] === "0" && ($positions['pos-main-enabled'] === "1") && ($positions['pos-mainRight-enabled'] === "0"))
                          {
                              // POSITION: main
                              \YAWK\template::getPositionDivBox($db, $lang, "main", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainLeft-enabled'] === "0" && ($positions['pos-main-enabled'] === "0") && ($positions['pos-mainRight-enabled'] === "1"))
                          {
                              // POSITION: mainRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainRight", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainLeft-enabled'] === "1" && ($positions['pos-main-enabled'] === "1") && ($positions['pos-mainRight-enabled'] === "0"))
                          {
                              // POSITION: mainLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: main
                              \YAWK\template::getPositionDivBox($db, $lang, "main", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainLeft-enabled'] === "0" && ($positions['pos-main-enabled'] === "1") && ($positions['pos-mainRight-enabled'] === "1"))
                          {
                              // POSITION: main
                              \YAWK\template::getPositionDivBox($db, $lang, "main", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainLeft-enabled'] === "1" && ($positions['pos-main-enabled'] === "0") && ($positions['pos-mainRight-enabled'] === "1"))
                          {
                              // POSITION: main
                              \YAWK\template::getPositionDivBox($db, $lang, "mainLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          ?>
                      </div>
                      <div class="row">
                          <?php
                          // POSITION: mainBottom
                          \YAWK\template::getPositionDivBox($db, $lang, "mainBottom", 0, "col-md-12", $positions, $indicators, $template);
                          ?>
                      </div>
                      <div class="row">
                          <?php
                          if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainBottomLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomLeft", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainBottomCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomCenter", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainBottomRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomRight", 0, "col-md-4", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "0") && ($positions['pos-mainBottomRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomLeft", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "0" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomCenter", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "0" && ($positions['pos-mainBottomCenter-enabled'] === "0") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomRight", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomCenter", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "0" && ($positions['pos-mainBottomCenter-enabled'] === "1") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomCenter", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainBottomLeft-enabled'] === "1" && ($positions['pos-mainBottomCenter-enabled'] === "0") && ($positions['pos-mainBottomRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainBottomRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          ?>
                      </div>
                      <div class="row">
                          <?php
                          // POSITION: mainFooter
                          \YAWK\template::getPositionDivBox($db, $lang, "mainFooter", 0, "col-md-12", $positions, $indicators, $template);
                          ?>
                      </div>
                      <div class="row">
                          <?php
                          if ($positions['pos-mainFooterLeft-enabled'] === "1" && ($positions['pos-mainFooterCenter-enabled'] === "1") && ($positions['pos-mainFooterRight-enabled'] === "1"))
                          {
                              // POSITION: mainFooterLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterLeft", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainFooterCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterCenter", 0, "col-md-4", $positions, $indicators, $template);
                              // POSITION: mainFooterRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterRight", 0, "col-md-4", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainFooterLeft-enabled'] === "1" && ($positions['pos-mainFooterCenter-enabled'] === "0") && ($positions['pos-mainFooterRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterLeft", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainFooterLeft-enabled'] === "0" && ($positions['pos-mainFooterCenter-enabled'] === "1") && ($positions['pos-mainFooterRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterCenter", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainFooterLeft-enabled'] === "0" && ($positions['pos-mainFooterCenter-enabled'] === "0") && ($positions['pos-mainFooterRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterRight", 0, "col-md-12", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainFooterLeft-enabled'] === "1" && ($positions['pos-mainFooterCenter-enabled'] === "1") && ($positions['pos-mainFooterRight-enabled'] === "0"))
                          {
                              // POSITION: mainTopLeft
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterCenter", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainFooterLeft-enabled'] === "0" && ($positions['pos-mainFooterCenter-enabled'] === "1") && ($positions['pos-mainFooterRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterCenter", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          else if ($positions['pos-mainFooterLeft-enabled'] === "1" && ($positions['pos-mainFooterCenter-enabled'] === "0") && ($positions['pos-mainFooterRight-enabled'] === "1"))
                          {
                              // POSITION: mainTopCenter
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterLeft", 0, "col-md-6", $positions, $indicators, $template);
                              // POSITION: mainTopRight
                              \YAWK\template::getPositionDivBox($db, $lang, "mainFooterRight", 0, "col-md-6", $positions, $indicators, $template);
                          }
                          ?>
                      </div>
                  </div>
                  <?php
                  // POSITION: outerLeft
                  \YAWK\template::getPositionDivBox($db, $lang, "rightMenu", 0, "col-md-2", $positions, $indicators, $template);
                  ?>
                  <!-- <div class="col-md-2 posbox" id="pos_rightMenu" style="height: 410px; margin-bottom:5px; text-align: center;">&laquo;rightMenu&raquo;</div> -->
              </div>

              <div class="row">
                  <?php
                  // POSITION: footer
                  \YAWK\template::getPositionDivBox($db, $lang, "footer", 0, "col-md-12", $positions, $indicators, $template);
                  ?>
              </div>
              <div class="row">
                  <?php
                  // POSITION: hiddenToolbar
                  \YAWK\template::getPositionDivBox($db, $lang, "hiddenToolbar", 0, "col-md-12", $positions, $indicators, $template);
                  ?>
              </div>
              <div class="row">
                  <?php
                  // POSITION: debug
                  \YAWK\template::getPositionDivBox($db, $lang, "debug", 0, "col-md-12", $positions, $indicators, $template);
                  ?>
              </div>
          </div>

          <?php
          // POSITION: outerRight
          \YAWK\template::getPositionDivBox($db, $lang, "outerRight", 0, "col-md-2", $positions, $indicators, $template);
          ?>

      </div>

      <!-- <div class="navbar-fixed-bottom"> -->
      <div class="row">
          <?php
          // POSITION: outerBottom
          \YAWK\template::getPositionDivBox($db, $lang, "outerBottom", 0, "col-md-12", $positions, $indicators, $template);
          ?>
      </div>
  </div>

  <!-- LAYOUT END -->

      <script>



              /*
              // Add smooth scrolling to all links in navbar + footer link
              $(".submenu a, a[href='#home']").on('click', function(event) {
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
/*
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
          */
      </script>

 </body>
</html>