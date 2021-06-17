<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\sys;

/** @var $db db */
/** @var $lang language */

echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
$host = sys::getHost($db);
echo backend::getTitle($lang['TPL'], $lang['PREVIEW']);
echo backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- title header -->
<div class="box">
    <div class="box-body">
        <div class="col-md-10">
            <?php echo "<h4><i class=\"fa fa-eye\"></i> &nbsp;$lang[PREVIEW] $lang[OF] <small>$host</small></h4>"; ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
        </div>
    </div>
</div>
<div class="row">
<!-- PREVIEW -->
<div class="col-md-12">
<!-- website preview iframe -->
    <div class="embed-responsive embed-responsive-4by3">
       <iframe id="preview" class="embed-responsive-item" src="../index.php"></iframe>
    </div>
</div>
</div>