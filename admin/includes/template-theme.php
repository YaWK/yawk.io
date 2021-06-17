<?php

use YAWK\db;
use YAWK\language;
use YAWK\template;
use YAWK\user;

/** @var $db db */
/** @var $lang language */

// new template object if not exists
if (!isset($template)) { $template = new template(); }
// new user object if not exists
if (!isset($user)) { $user = new user($db); }
// $_GET['id'] or $_POST['id'] holds the template ID to edit.
// If any one of these two is set, we're in "preview mode" - this means:
// The user database holds two extra cols: overrideTemplate(int|0,1) and templateID
// Any user who is allowed to override the Template, can edit a template and view it
// in the frontend. -Without affecting the current active theme for any other user.
// This is pretty cool when working on a new design: because you see changes, while others wont.
// In theory, thereby every user can have a different frontend template activated.
?>

<!-- SETTINGS -->
<script>
    /* increase brightness of given hex color code
       hex str the hex color code
       percent int 50 would make it 50% brighter
    */
    function getContrast50(hexcolor){
        // strip the leading # if it's there
        hexcolor = hexcolor.replace(/^\s*#|\s*$/g, '');
        return (parseInt(hexcolor, 16) > 0xffffff/2) ? '#000000':'#ffffff';
    }

    function increase_brightness(hex, percent)
    {
        // strip the leading # if it's there
        hex = hex.replace(/^\s*#|\s*$/g, '');

        // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
        if(hex.length === 3){
            hex = hex.replace(/(.)/g, '$1$1');
        }
        // set rgb values
        var r = parseInt(hex.substr(0, 2), 16),
            g = parseInt(hex.substr(2, 2), 16),
            b = parseInt(hex.substr(4, 2), 16);

        return '#' +
            ((0|(1<<8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
            ((0|(1<<8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
            ((0|(1<<8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
    }

    function get_middle(hex1, hex2)
    {
         // prepare vars
         var color1 = hex1;
         var color2 = hex2;
         // set ratio
         var ratio = 0.5;
         var hex = function(x) {
         x = x.toString(16);
         return (x.length === 1) ? '0' + x : x;
         };

         var r = Math.ceil(parseInt(color1.substring(0,2), 16) * ratio + parseInt(color2.substring(0,2), 16) * (1-ratio));
         var g = Math.ceil(parseInt(color1.substring(2,4), 16) * ratio + parseInt(color2.substring(2,4), 16) * (1-ratio));
         var b = Math.ceil(parseInt(color1.substring(4,6), 16) * ratio + parseInt(color2.substring(4,6), 16) * (1-ratio));
         var middle = hex(r) + hex(g) + hex(b);

         c1 = '#'+color1;
         c2 = '#'+color2;
         c3 = '#'+middle;

        return c3;

        /*
         $("#color1").css('background-color', c1);
         $("#color2").css('background-color', c2);
         $("#color3").css('background-color', c3);
         */
    }

</script>
<script>
    baseColor1 = '#C02B52';
    var _1bright1 = increase_brightness(baseColor1, 25); // would make it 50% brighter
    var _1bright2 = increase_brightness(_1bright1, 50); // would make it 50% brighter
    var _1bright3 = increase_brightness(_1bright2, 75); // would make it 50% brighter
    var _1bright4 = increase_brightness(_1bright3, 75); // would make it 50% brighter
    var contrast = getContrast50(baseColor1);
    var text = getContrast50(contrast);
    $("#1-baseColor").css('background-color', baseColor1).append(baseColor1);
    $("#1-color1").css('background-color', _1bright1).append(_1bright1);
    $("#1-color2").css('background-color', _1bright2).append(_1bright2);
    $("#1-color3").css('background-color', _1bright3).append(_1bright3);
    $("#1-color4").css('background-color', _1bright4).append(_1bright4);
    $("#1-contrast").css('background-color', contrast).append(contrast).css('text-color', text);

    baseColor2 = '#3BC068';
    var _2bright1 = increase_brightness(baseColor2, 25); // would make it 50% brighter
    var _2bright2 = increase_brightness(_2bright1, 50); // would make it 50% brighter
    var _2bright3 = increase_brightness(_2bright2, 75); // would make it 50% brighter
    var _2bright4 = increase_brightness(_2bright3, 75); // would make it 50% brighter
    var contrast2 = getContrast50(baseColor2);
    var text2 = getContrast50(contrast2);
    $("#2-baseColor").css('background-color', baseColor2).append(baseColor2);
    $("#2-color1").css('background-color', _2bright1).append(_2bright1);
    $("#2-color2").css('background-color', _2bright2).append(_2bright2);
    $("#2-color3").css('background-color', _2bright3).append(_2bright3);
    $("#2-color4").css('background-color', _2bright4).append(_2bright4);
    $("#2-contrast").css('background-color', contrast2).append(contrast2).css('text-color', text2);

    // baseColor3 = '#FF8300';
    baseColor3 = '#9BC060';
    var _3bright1 = increase_brightness(baseColor3, 25); // would make it 50% brighter
    var _3bright2 = increase_brightness(_3bright1, 50); // would make it 50% brighter
    var _3bright3 = increase_brightness(_3bright2, 75); // would make it 50% brighter
    var _3bright4 = increase_brightness(_3bright3, 75); // would make it 50% brighter
    var contrast3 = getContrast50(baseColor3);
    var text3 = getContrast50(contrast3);
    $("#3-baseColor").css('background-color', baseColor3).append(baseColor3);
    $("#3-color1").css('background-color', _3bright1).append(_3bright1);
    $("#3-color2").css('background-color', _3bright2).append(_3bright2);
    $("#3-color3").css('background-color', _3bright3).append(_3bright3);
    $("#3-color4").css('background-color', _3bright4).append(_3bright4);
    $("#3-contrast").css('background-color', contrast3).append(contrast3).css('text-color', text3);
</script>

<script type="text/css">

</script>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['TPL'], $lang['SET_COLORS']);
echo \YAWK\backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- title header -->
<div class="box">
    <div class="box-body">
        <div class="col-md-10">
            <?php echo "<h4><i class=\"fa fa-tint\"></i> &nbsp;$lang[THEME]  <small>$lang[SET_COLORS]</small></h4>"; ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['DESIGN_SAVE']; ?></button>
        </div>
    </div>
</div>

<div class="row animated fadeIn">
    <!-- col 1 -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[COLOR] <small>$lang[COLOR]</small>"; ?></h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
    <!-- col 2 -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[COLOR] <small>$lang[COLOR]</small>"; ?></h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
</div>