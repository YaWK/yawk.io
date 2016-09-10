<?php
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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=backup\" title=\"Backup\"> Backup</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
 <a class="btn btn-success" href="index.php?page=backup&start=1"><i class="fa fa-save"></i>&nbsp; Backup erstellen</a>

 <div class="span6">
  <h1>Backup <small>Files</small></h1><hr>
  <?	backup::getPackages();	?>
 </div>

 <div class="span6">
  <h1>Download <small>Packages</small></h1><hr>
     <a class="btn" href="index.php?page=backup&download_all=1">Download all Packages</a>
     <br><br>
     <h1>Delete <small>Files in stack</small></h1><hr>
     <a id="savebutton2" class="btn" href="index.php?page=backup&delete_all=1">Backups l&ouml;schen</a>
 </div>
