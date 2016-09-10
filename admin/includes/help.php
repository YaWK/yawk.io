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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=help\" title=\"Help\"> Help</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<iframe src="../../../yawk-LTE-docs/index.html"
        width="100%"
        height="840"
        border="none"
        scrolling="yes"
        frameborder="0">
    <p>Sorry, your Browser do not support iframes.</p>
</iframe>
<br><br><br><br>