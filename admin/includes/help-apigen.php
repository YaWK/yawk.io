<?php

use YAWK\backend;
use YAWK\language;
use YAWK\db;
/* @var $db db */
/* @var $lang language */
?>
<style type="text/css">
    iframe:focus {
        outline: none;
    }

    iframe[seamless] {
        display: block;
    }
</style>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['HELP'], $lang['HELP_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=help\" title=\"$lang[HELP]\"> $lang[HELP]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- btn clear log -->

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $lang['HELP_APIGEN']; ?></h3>
    </div>
    <div class="box-body">
<!-- APIGEN IFRAME -->
<iframe src="http://docs.yawk.io/"
        width="100%"
        height="840"
        scrolling="yes"
        frameborder="0">
</iframe>
    </div>
</div>
<br><br><br><br>