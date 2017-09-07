
<script>
    $(document).ready(function() {
        var baseURL = document.location.origin;
        var baseDir = '<?php echo \YAWK\sys::getBaseDir(); ?>';

        home = $("#tab-overview");  // set this tab as home
        home.click(function() {
            fn = baseURL+baseDir+"index.php?page=template-overview&hideWrapper=1";
            $("#tabcontent-overview").load( fn );
        });

        $("#tab-positions").click(function() {
            fn = baseURL+baseDir+"index.php?page=template-positions&hideWrapper=1";
            $("#tabcontent-positions").load( fn );
        });
        $("#tab-theme").click(function() {
            fn = baseURL+baseDir+"index.php?page=template-theme&hideWrapper=1";
            $("#tabcontent-theme").load( fn );
        });

        $("#tab-redesign").click(function() {
            fn = baseURL+baseDir+"index.php?page=template-redesign&hideWrapper=1";
            $("#tabcontent-redesign").load( fn );
        });

        $("#tab-customcss").click(function() {
            fn = baseURL+baseDir+"index.php?page=template-customcss&hideWrapper=1";
            $("#tabcontent-customcss").load( fn );
        });

        $("#tab-settings").click(function() {
            fn = baseURL+baseDir+"index.php?page=template-settings&hideWrapper=1";
            $("#tabcontent-settings").load( fn );
        });
        // set default active tab
        // home.trigger("click");

        /* MAKE SURE THAT THE LAST USED TAB STAYS ACTIVE */
        $(function() {
            // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save the latest tab; use cookies if you like 'em better:
                localStorage.setItem('lastTab', $(this).attr('href'));
                // save the latest tabcontent id
                localStorage.setItem('lastTabContent', $(this).attr('id'));
                // remove first char (#) to get correct filename
                var file = $(this).attr('href').slice(1);
                // store filename from last tab
                localStorage.setItem('lastFile', file);
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastTab');
            // get latest filename
            var lastFile = localStorage.getItem('lastFile');
            // get latest tab content id
            var lastTabContent = localStorage.getItem('lastTabContent');
            // remove first 4 chars from tabcontent id str
            var tab = lastTabContent.substr(4);
            // and build correct tabcontent id str
            var tabContent = '#tabcontent-'+tab;
            // build latest url
            var lastPage = baseDir+'index.php?page='+lastFile+'&hideWrapper=1';

            // if a last tab exists...
            if (lastTab) {
                // show it up
                $('[href="' + lastTab + '"]').tab('show');
                // load latest page into last opened content tab
                $(tabContent).load(lastPage);
            }
            else
                {   // no last tab found, load overview as default home tab
                    home.trigger("click");
                }
        });
    });// end document ready
</script>
<?php
// check if template obj is set and create if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user obj if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
$t = "$lang[TEMPLATE] $lang[SET_AND_EDIT]";
echo \YAWK\backend::getTitle($lang['TPL_MANAGER'], $t);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=template-manage\" title=\"$lang[TPL_MANAGER]\"> $lang[TPL_MANAGER]</a></li>
            <li><b><a href=\"index.php?page=template-edit&id=$template->id\" class=\"active\" title=\"$lang[TPL_EDIT]\">$template->name</a></b></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
// check if any action is requested
if (isset($_GET['id']) && (isset($_GET['action'])))
{
    // check if it's about positions
    if ($_GET['action'] === "template-positions")
    {
        echo $_GET['id'];
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo "<h3>".count($_POST)."</h3>";
    }
    // check if it's about design
    if ($_GET['action'] === "template-redesign")
    {
        echo $_GET['id'];
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo "<h3>".count($_POST)."</h3>";
    }
}


echo '
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#template-overview" id="tab-overview"><i class="fa fa-home"></i>&nbsp;'.$lang['OVERVIEW'].'</a></li>
  <li><a data-toggle="tab" href="#template-positions" id="tab-positions"><i class="fa fa-cube"></i>&nbsp;'.$lang['POSITIONS'].'</a></li>
  <li><a data-toggle="tab" href="#template-theme" id="tab-theme"><i class="glyphicon glyphicon-tint"></i>&nbsp;'.$lang['THEME'].'</a></li>
  <li><a data-toggle="tab" href="#template-redesign" id="tab-redesign"><i class="fa fa-paint-brush"></i>&nbsp;'.$lang['DESIGN'].'</a></li>
  <li><a data-toggle="tab" href="#template-customcss" id="tab-customcss"><i class="fa fa-css3"></i>&nbsp;'.$lang['CUSTOM_CSS'].'</a></li>
  <li><a data-toggle="tab" href="#template-settings" id="tab-settings"><i class="fa fa-wrench"></i>&nbsp;'.$lang['SETTINGS'].'</a></li>
</ul>
<div class="tab-content">
  <div id="template-overview" class="tab-pane fade in active">
    <p id="tabcontent-overview"></p>
  </div>
  <div id="template-positions" class="tab-pane fade">
    <p id="tabcontent-positions"></p>
  </div>
  <div id="template-theme" class="tab-pane fade">
    <p id="tabcontent-theme"></p>
  </div>
  <div id="template-redesign" class="tab-pane fade">
    <p id="tabcontent-redesign"></p>
  </div>
  <div id="template-customcss" class="tab-pane fade">
    <p id="tabcontent-customcss"></p>
  </div>
  <div id="template-settings" class="tab-pane fade">
    <p id="tabcontent-settings"></p>
  </div>
</div>';
?>
