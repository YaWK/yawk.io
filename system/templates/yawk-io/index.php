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
if (isset($_POST['email']) && (!empty($_POST['email'])))
{
    if (!isset($db))
    {
        @require_once 'system/classes/db.php';
        $db = new \YAWK\db();
    }
    $email = $db->quote($_POST['email']);
    $now = \YAWK\sys::now();
    if ($db->query("INSERT INTO {newsletter} (date_created, email) VALUES('".$now."', '".$email."')"))
    {
        $htmlcode = "<h2>Thank you $email</h2>";
    }
    else
        {
            $htmlcode = "<h2>Could not add your email address</h2>";
        }
}
else
    {
        $htmlcode = "<form id=\"form\" class=\"form-inline animated fadeIn\" method=\"post\">
                      <input type=\"text\" id=\"email\" placeholder=\"your@email.com\" name=\"email\" size=\"50\" class=\"form-control\">
                      <button type=\"submit\" id=\"submit\" name=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-twitter\"></i>&nbsp; Subscribe as early bird</button>
                  </form>";
    }
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
    <link rel="stylesheet" href="system/engines/animateCSS/animate.min.css" type="text/css" media="all">
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
<noscript><br><br><h2 style="text-align: center;">This page requires a modern browser with javascript. <br><small>Please activate Javascript or use a better browser.</small></h2></noscript>
<!-- gfonts -->
<?php
// include additional html header stuff & local meta tags
\YAWK\sys::includeHeader($db);
// load active google font code
\YAWK\template::outputActivegFont($db);
?>
<!-- /gfonts -->
  </head>
  <body style="<?php echo YAWK\template::getActivegfont($db, "", "text-gfont"); ?>" ondragstart="return false">
      <!-- YAWK NAV -->
    <div style="<?php echo YAWK\template::getActivegfont($db, "", "menu-gfont"); ?>">
    <?php echo YAWK\template::setPosition($db, "globalmenu-pos"); ?>  <!-- GLOBALMENU -->
      <!--/ END NAV -->
    </div>
  <!-- </div> -->
      <!-- :PLUGINS  -->
      <div class="well text-center gradient-bg" id="home">
              <!-- 1st row -->
              <h1 class="white animated fadeIn">YaWK.io<small><br><label for="subscribe" class="white">Yet another WebKit CMS</label></small></h1><br>
                  <?php echo $htmlcode; ?>
          <br>
                <h3 id="comingTeaser">...coming 1<sup>st</sup> Quarter 2017<br>signup now for closed beta-test</h3>
          <br>
      </div>

      <!-- :MAIN component for a primary marketing message or call to action -->
      <div class="well">
      <?php echo YAWK\template::setPosition($db, "main-pos"); ?>
      </div>

      <!-- :bottom component for a primary marketing message or call to action -->
      <div class="well text-center grey-bg" id="responsive">
              <br><br>
                  <h3>
                      RESPONSIVE DESIGN <small>as a matter of course</small><br>
                      <img src="media/images/responsiveDesign.jpg" class="img-thumbnail pull-left slideanim" style="margin-right:20px;">
                      <small>follows YaWK a consequent ideology.
                      </small>
                  </h3>
                  <p>Responsive design is not just a buzzword - it's a consequence of quality. 2016 - there are several hundreds
                      of devices out there. People are not browsing through the internet just only at home from their computers
                      anymore. A good project is ready for the chances of our faster growing world - fit for every situation.
                      YaWK works well with every device, no matter if it's a mobile phone, a tablet or any desktop computer.
                      YaWK-powered Websites are looking good in every situation. This is the goal. <b>Tested with 800+ smartphones, tablets, desktop and browser combinations (so far).</b> </p>

                  <br><br><br><br><br><br>
                  <br><br><br>

      </div>


      <!-- :FEATURES -->
      <div class="bottom-pos text-center well" id="features">
              <br><br><h2>Features<br><small>built-in, powerful tools</small></h2><br><br>
              <!-- 1st row -->
                  <div class="col-md-4 slideanim"><i class="fa fa-user fa-3x orange"></i><h4>User Management<br><small>manage users &amp; groups</small><br><br><br><br></h4></div>
                  <div class="col-md-4 slideanim"><i class="fa fa-line-chart fa-3x orange"></i><h4>Statistics<br><small>count hits, devices, browsers and more</small><br><br><br><br></h4></div>
                  <div class="col-md-4 slideanim"><i class="fa fa-paint-brush fa-3x orange"></i><h4>ReDesign Bootstrap<br><small>override bootstrap colors with a few clicks<br></small><br><br><br><br></h4></div>
              <br>
                  <div class="col-md-4 slideanim"><i class="fa fa-folder-open-o fa-3x orange"></i><h4>File Manager<br><small>overview and upload files</small><br><br><br><br></h4></div>
                  <div class="col-md-4 slideanim"><i class="fa fa-code fa-3x orange"></i><h4>Code Editor<br><small>powerful html/css editing</small></h4><br><br><br><br></div>
                  <div class="col-md-4 slideanim"><i class="fa fa-gears fa-3x orange"></i><h4>Admin LTE Backend<br><small>powerful website admin tools</small><br><br><br><br></h4></div>

              <br><br><br><br>
              <br><br><br><br>
              <br><br><br><br>
              <br><br><br><br>
      </div>

      <!-- :PLUGINS  -->
      <div class="bottom-pos well grey-bg" id="plugins">
          <div class="text-center">
              <br><br><h2>Plugins <br><small>powerUp your webpage with free extensions</small></h2><br><br>
              <!-- 1st row -->
                  <div class="col-md-4 slideanim"><i class="fa fa-newspaper-o fa-3x orange"></i><h4>Blog Plugin<br><small>build your own successful blog</small></h4></div>
                  <div class="col-md-4 slideanim"><i class="fa fa-photo fa-3x orange"></i><h4>Gallery Plugin<br><small>create stunning image galleries</small></h4></div>
                  <div class="col-md-4 slideanim"><i class="fa fa-comments-o fa-3x orange"></i><h4>Booking Plugin<br><small>allow users to book an appointment<br></small><br><br></h4></div>
              <br><br><br><br>
              <br><br><br><br>
              <br><br><br><br>
          </div>
      </div>



      <!-- SCREENCAST / :SHOWCASE -->
      <div class="gradient-bg-dark bottom-pos well" id="screencast">
          <div class="text-center slideanim">
              <br><br><br><h3 class="white">Screencast <br><small class="grey">...coming soon...</small></h3><br><br>

             <!-- <img src="http://placehold.it/720x440" class="img-thumbnail"> -->
              <img src="media/images/yawk-alpha-screenshot.png" width="920" class="img-thumbnail">
          </div>
          <br><br><br><br>
          <br><br><br><br>
      </div>


      <!-- GITHUB -->
      <div class="black-bg" id="github">
          <div class="text-center">
              <br><br><br><br>
              <br><br><br><br>
              <h3 class="white slideanim">GitHub<br><a href="https://github.com/YaWK/" target="_blank" title="GitHub - opening soon">https://github.com/YaWK</a><br> <small>repository opening soon!</small><br><br>
              <a href="#home"><i class="up white fa fa-chevron-up"></i></a> </h3><br><br>

          <p class="text-center">
              <small class="white">
                  proudly presented by YaWK :: Yet another WebKit <br>
                  <small><i class="fa fa-copyright"></i> <?php print date("Y"); ?> <?php echo YAWK\settings::getSetting($db, "host"); ?></small>
              </small>
          </p>
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
          <br><br><br><br>
          </div>
          <?php echo YAWK\template::setPosition($db, "analytics-pos"); ?>
          <?php echo YAWK\template::setPosition($db, "bottom-pos"); ?>
          <?php echo YAWK\template::setPosition($db, "footer-pos"); ?>
      </div>

      <!-- <div class="container">  -->
      <!--   </div> /container -->
    <div class="container">
    <?php // echo YAWK\template::setPosition($db, "debug-pos"); ?>
    </div>
      <script>
          $(document).ready(function(){
              $("#globe").addClass("slide");
              $("#comingTeaser").addClass("slide");

              $("#form").validate({
                  invalidHandler: function(form, validator){
                      var errors = validator.numberOfInvalids();
                      if (errors == 1){
                          $( "#form" ).effect( "shake", {times:2}, 600 );
                      }
                      // var message = (errors == 1) ? "One of your groups won't validate." : "Neither of your groups will validate.";
                      // alert(message);
                  },
                  rules: {
                      email: {
                          required: true,
                          email: true
                      }
                  },
                  messages: {
                      email: "Please enter a valid email address"
                  },
                  errorPlacement: function(error, element) {
                      error.insertBefore(element);
                  }
              }); // ./ end validate inviteForm


              // Add smooth scrolling to all links in navbar + footer link
              $(".navbar a, a[href='#home'], footer a[href='#myPage']").on('click', function(event) {

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