<script>
    $(document).ready(function() {
        var basePath = window.location.pathname;
        var baseURL = document.location.origin;

        home = $("#tab-overview");  // set this tab as home
        home.click(function() {
            fn = baseURL+"/yawk-LTE/admin/index.php?page=template-overview&hideWrapper=1";
            $("#tabcontent-overview").load( fn );
        });

        $("#tab-positions").click(function() {
            fn = baseURL+"/yawk-LTE/admin/index.php?page=template-positions&hideWrapper=1";
            $("#tabcontent-positions").load( fn );
        });

        $("#tab-design").click(function() {
            fn = baseURL+"/yawk-LTE/admin/index.php?page=template-redesign&hideWrapper=1";
            $("#tabcontent-design").load( fn );
        });

        $("#tab-customcss").click(function() {
            fn = baseURL+"/yawk-LTE/admin/index.php?page=users&hideWrapper=1";
            $("#tabcontent-customcss").load( fn );
        });

        $("#tab-settings").click(function() {
            fn = baseURL+"/yawk-LTE/admin/index.php?page=settings-manage&hideWrapper=1";
            $("#tabcontent-settings").load( fn );
        });
       // set default active tab
       home.trigger("click");

    });
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['TPL'], $lang['SET_AND_EDIT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=search\" title=\"$lang[SEARCH]\"> $lang[SEARCH]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */


echo '
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#tpl-overview" id="tab-overview"><i class="fa fa-home"></i>&nbsp;'.$lang['OVERVIEW'].'</a></li>
  <li><a data-toggle="tab" href="#tpl-positions" id="tab-positions"><i class="fa fa-cube"></i>&nbsp;'.$lang['POSITIONS'].'</a></li>
  <li><a data-toggle="tab" href="#tpl-design" id="tab-design"><i class="fa fa-paint-brush"></i>&nbsp;'.$lang['DESIGN'].'</a></li>
  <li><a data-toggle="tab" href="#tpl-customcss" id="tab-customcss"><i class="fa fa-css3"></i>&nbsp;'.$lang['CUSTOM_CSS'].'</a></li>
  <li><a data-toggle="tab" href="#tpl-settings" id="tab-settings"><i class="fa fa-wrench"></i>&nbsp;'.$lang['SETTINGS'].'</a></li>
</ul>
<div class="tab-content">
  <div id="tpl-overview" class="tab-pane fade in active">
    <p id="tabcontent-overview"></p>
  </div>
  <div id="tpl-positions" class="tab-pane fade">
    <p id="tabcontent-positions"></p>
  </div>
  <div id="tpl-design" class="tab-pane fade">
    <p id="tabcontent-design"></p>
  </div>
  <div id="tpl-customcss" class="tab-pane fade">
    <h3>'.$lang['CUSTOM_CSS'].'</h3>
    <p id="tabcontent-customcss"></p>
  </div>
  <div id="tpl-settings" class="tab-pane fade">
    <h3>'.$lang['SETTINGS'].'</h3>
    <p id="tabcontent-settings"></p>
  </div>
</div>';
?>
