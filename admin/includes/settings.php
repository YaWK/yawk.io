<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['SETTINGS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=settings-backend\" class=\"active\" title=\"Backend Settings\"> Backend Settings</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

/* draw Title on top */
 // YAWK\backend::getTitle($lang['SETTINGS'],$lang['SETTINGS_SUBTEXT']);

if(isset($_POST['save'])){
 foreach($_POST as $property=>$value){
   if($property != "save"){
     setSetting($property,$value);
   }
 }
}
?>

      <div class="row">
            <div class="col-md-4">
              <h2>Template <small><i class="fa fa-tint"></i> Layout, Design, Colors</small></h2>
              <img src="template/icons/ico-blue-colorplate.png" style="float:left; margin-right:10px;"> 
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, 
              tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem 
              malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default pull-right" href="index.php?page=template-settings">Template Settings &raquo;</a></p>
            </div><!--/span-->
            
            <div class="col-md-4">
              <h2>Site <small><i class="fa fa-tasks"></i> Status, Title, Meta</small></h2>
              <img src="template/icons/ico-blue-site.png" style="float:left; margin-right:10px;"> 
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo,
              tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem 
              malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default pull-right" href="#">Website Settings &raquo;</a></p>
            </div><!--/span-->
            
            <div class="col-md-4">
              <h2>Social <small><i class="fa fa-twitter"> <i class="fa fa-facebook"></i></i> Facebook, Twitter</small></h2>
              <img src="template/icons/ico-blue-social.png" style="float:left; margin-right:10px;"> 
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, 
              tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem 
              malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default pull-right" href="#">Social Media Features &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
          
          
          <hr>
          
          <div class="row"> 
            <div class="col-md-4">
              <h2>User <small><i class="fa fa-user"></i> Add, Edit, Block, Delete </small></h2>
              <img src="template/icons/ico-blue-user.png" style="float:left; margin-right:10px;"> <p>User Verwaltung. Hier kannst Du neue Benutzer anlegen,
                l&ouml;schen, bearbeiten, blockieren, Rechte vergeben, das Passwort &auml;ndern und vieles mehr.
                </p><p><a class="btn btn-default pull-right" href="index.php?page=users">User Management &raquo;</a></p>
            </div><!--/span-->
            
            <div class="col-md-4">
              <h2>System <small><i class="fa fa-cog"></i> YaWK, Server, Settings</small></h2>
              <img src="template/icons/ico-blue-cogwheel.png" style="float:left; margin-right:10px;"> <p>Allgemeine YaWK-Einstellungen. Hier wird die Verbindung 
              zur Datenbank konfiguriert, sowie Pfade, Tasks und verschiedene globale Settings. </p>
              <p><a class="btn btn-default pull-right" href="index.php?page=settings-system#server">System Settings &raquo;</a></p>
            </div><!--/span-->
            
            
            <div class="col-md-4">
              <h2>Extend <small><i class="fa fa-dropbox"></i> with Widgets and Apps</small></h2>
              <img src="template/icons/ico-blue-extend.png" style="float:left; margin-right:10px;"> 
              <p>Widgets sind Erweiterungen f&uuml;r kleine und gro&szlig;e Aufgaben. 
              Facebook, Galerien, Mediaplayer und viele n&uuml;tzliche mehr sind  bereits integriert. </p>
              <p><a class="btn btn-default pull-right" href="#">get more out of YaWK &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->

