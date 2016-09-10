<script type="text/javascript">
   $(document).ready(function () {
     // first of all, hide the reg header
       $("#movie").hide();
       $("#chapter2").hide();
       $("#chapter3").hide();
       $("#static").hide();
       $("#img-static").hide();

       movie();

       function movie(){
       $( "#movie" )
           .fadeIn(1400, function() {

           // Animation complete.
           $("#chapter1")
               .fadeIn(1400)
               .delay(3600)
               .fadeOut(1200, function() {
                   $("#chapter2")
                       .fadeIn(1400)
                       .delay(3600)
                       .fadeOut(1200, function() {
                           $("#chapter3")
                               .fadeIn(1400)
                               .delay(3600)
                               .fadeOut(1200, function() {
                           // after fade out
                           $('#chapter1')
                           .fadeIn(1400);
                        //   movie();
                       });
                       });
               });
       });
       }

// Returns width of browser viewport
       var eventFired = 0;
       if ($(window).width() < 720) {
           $("#movie").hide();
           $("#static").show();
           $("#img-static").show();
        //   $("#movie").css("margin-bottom", "100px");
         //   $( "#chapter1" ).html( "<img src='media/images/header-01.jpg' class='img-responsive'>" );
           // alert('Less than 720');
           eventFired = 1;
       }
       else {
           // alert('More than 720');
           $("#movie").show();
       }

       $(window).on('resize', function() {
           if (!eventFired) {
               if ($(window).width() > 720) {
                   $('#static').hide();
                   $('#movie').show();
                   // alert('Less more than 720 resize');
               } else {
                   //  alert('More than 720 resize');
                   $('#movie').hide();
                   $('#static').show();
                   $('#img-static').show();
               }
           }
       });
   });
</script>
<?php
$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
date_default_timezone_set("Europe/Berlin");
$tag = date("w");
$today = $tage[$tag];
?>

<div id="movie" class="row">
    <div id="chapter1" class="chapter1">&nbsp; </div>
    <div id="chapter2" class="chapter2">&nbsp; </div>
    <div id="chapter3" class="chapter3">&nbsp; </div>
</div>

<div id="static" class="container row" style="margin-top: -20px; display: none;">
    <div id="img-static" class="img-static">&nbsp; </div>
</div>
