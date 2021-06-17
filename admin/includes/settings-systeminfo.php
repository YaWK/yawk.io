<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\sys;

/** @var $db db */
/** @var $lang language */

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['SETTINGS'], $lang['INFO']);
echo backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-info-circle\"></i> &nbsp;".$lang['SYSTEMINFO_SUBTEXT']."</h4>"; ?>
            </div>
            <div class="col-md-2">
                <!-- <button class="btn btn-success pull-right" id="clear" name="clear" style="margin-top:2px;"><i class="fa fa-times"></i>&nbsp;&nbsp;<?php // echo $lang['CLEAR']; ?></button> -->
            </div>
        </div>
    </div>
    <div class="row">
        <!-- systeminfo -->
        <div class="col-md-8">
            <!-- theme selector -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?PHP echo $lang['SEARCH_PHPINFO']."&nbsp;<small>".$lang['SEARCH_PHPINFO_SUB']."</small>"; ?></h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                        <span class="label label-primary">phpinfo()</span>
                    </div>
                </div>
                <div class="box-body">
                <?php
                    sys::drawPhpInfo($lang);
                ?>
                </div>
            </div>
            <!-- /.box -->
        </div>


    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?PHP echo $lang['SYSTEM']."&nbsp;".$lang['INFORMATIONS']; ?></h3>
                <div class="box-tools pull-right">
                    <span class="label label-primary">Label</span>
                </div>
            </div>
            <div class="box-body">
                <?php echo $lang['PHP_HELP']; ?>

                <br><br>
                <i class="fa fa-lightbulb-o"></i>
                <i><?php echo $lang['PHP_TIP']; ?></i>

            </div>
        </div>
    </div>
<script>
    $( document ).ready(function() {
        $("#myInput").focus();
    });
</script>