<?php
/*
// check status and do what you need to do
if(isset($_GET['check']) && ($_GET['check']==1)) {
	backup::getPackages();
	}

if (isset($_GET['start']) && ($_GET['start']==1)) {
	backup::start();
	}

if (isset($_GET['delete_all']) && ($_GET['delete_all']==1)) {
	backup::deleteTarGzPackages();
	backup::deleteMediaPackages();
	backup::deleteSqlPackages();
	}
if (isset($_GET['download_all']) && ($_GET['download_all']==1)) {
	backup::downloadAllPackages();
	}

if (isset($_GET['delete_item'])) {
	$package = $_GET['delete_item'];
	backup::deletePackage($package);
	}
*/
?>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['BACKUP'], $lang['BACKUP_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=backup\" title=\"$lang[BACKUP]\"> $lang[BACKUP]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?php echo $lang['BACKUP']." ".$lang['SHOW_FILES']; ?>
            </h3>
        </div>
        <div class="box-body">
            <a class="btn btn-success pull-right" href="index.php?page=backup&start=1"><i class="fa fa-save"></i>&nbsp; Backup erstellen</a>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?php echo $lang['BACKUP']." ".$lang['BACKUP_SUBTEXT']; ?>
            </h3>
        </div>
        <div class="box-body">
            <a class="btn btn-success pull-right" href="index.php?page=backup&start=1"><i class="fa fa-save"></i>&nbsp; Backup erstellen</a>
        </div>
    </div>
</div>

 <div class="col-md-6">
  <?	// \YAWK\backup::getPackages();	?>
 </div>

 <div class="col-md-6">
     <div class="box">
         <div class="box-header">
             <h1 class="box-title">Download <small>Backup</small></h1><hr>
         </div>
         <div class="box-body">
             ...
         </div>
     </div>

     <div class="box">
         <div class="box-header">
             <h1 class="box-title">Download <small>Backup</small></h1><hr>
         </div>
         <div class="box-body">
             <a class="btn" href="index.php?page=backup&download_all=1">Download all Packages</a>
             <br><br>
             <h1>Delete <small>Backup</small></h1><hr>
             <a id="savebutton2" class="btn" href="index.php?page=backup&delete_all=1">Backups l&ouml;schen</a>
         </div>
     </div>
 </div>

