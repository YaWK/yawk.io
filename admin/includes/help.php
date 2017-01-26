<?php 
  YAWK\backend::getTitle($lang['HELP'], $lang['HELP_SUBTEXT']);
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
echo \YAWK\backend::getTitle($lang['HELP'], $lang['HELP_SUBTEXT']);
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
<a class="btn btn-success pull-right" href="index.php?page=syslog&clear=1">
    <i class="fa fa-trash-o"></i> &nbsp;<?php print $lang['HELP']; ?></a>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $lang['HELP']; ?></h3>
    </div>
    <div class="box-body">
<!-- APIGEN IFRAME
<iframe src="../../../yawk-LTE-docs/index.html"
        width="100%"
        height="840"
        border="none"
        scrolling="yes"
        frameborder="0">
    <p>Sorry, your Browser do not support iframes.</p>
</iframe>
-->
    </div>
</div>
<br><br><br><br>