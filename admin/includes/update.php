<?php
// IMPORT REQUIRED CLASSES
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\update;

/** @var $db db  */
/** @var $lang language  */

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['UPDATE'], $lang['UPDATE_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
        <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
        <li class=\"active\"><a href=\"index.php?page=update\" title=\"".$lang['UPDATE']."\"><i class=\"fa fa-code-fork\"></i>  ".$lang['UPDATE']."</a></li>
     </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

?>
<!-- CONTENT -->
<div class="box box-default">
    <div class="box-body">
        <a href="#checkForUpdatesBtn" id="checkForUpdatesBtn" class="btn btn-success pull-right"><i class="fa fa-refresh"></i> &nbsp;<?php echo $lang['UPDATE_CHECK']; ?></a>
        <h3 class="box-title"><?php echo $lang['UPDATE_CURRENT_INSTALLED_VERSION']; echo ' <span id="installedVersion">'; echo \YAWK\settings::getSetting($db,'yawkversion').'</span>';?></h3>
        <hr>
        <div id="statusBarNode"></div>
        <hr>
    </div>
</div>

<!-- 2cols -->
<div class="row">
<div class="col-md-6">
    <div class="box box-default">
        <div class="box-header with-border">
            <?php echo '<h3 class="box-title">Filebase <small>of your installation </small> '.\YAWK\backend::printTooltip($lang['UPDATE_INTEGRITY_TT']).'</h3>'; ?>
        </div>
        <div class="box-body">
            <div id="readFilebaseNode"></div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="box box-default">
        <div class="box-header with-border">
            <?php echo '<h3 class="box-title">Filebase <small>of the latest YaWK release </small> '.\YAWK\backend::printTooltip($lang['UPDATE_INTEGRITY_TT']).'</h3>'; ?>
        </div>
        <div class="box-body">
            <div id="readFilebaseNode"></div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="js/checkForUpdates.js"></script>