<script type="text/javascript">
    function saveHotkey() {
        // simply disables save event for chrome
        $(window).keypress(function (event) {
            if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
            event.preventDefault();
            formmodified=0; // do not warn user, just save.
            return false;
        });
        // used to process the cmd+s and ctrl+s events
        $(document).keydown(function (event) {
            if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                event.preventDefault();
                $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                formmodified=0; // do not warn user, just save.
                // save(event);
                return false;
            }
        });
    }
    saveHotkey();
    $(document).ready(function() {
        // textarea that will be transformed into editor
        const savebutton = ('#savebutton');
        const savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });
    });


</script>
<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- Bootstrap toggle css -->
<link rel="stylesheet" href="../system/engines/bootstrap-toggle/css/bootstrap-toggle.css">
<!-- Bootstrap toggle js -->
<script type="text/javascript" src="../system/engines/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\sys;
use YAWK\template;
use YAWK\widget;

/** @var $db db */
/** @var $lang language */
/* page content start here */
// check if widget obj is set
if (!isset($widget))
{   // create new widget object
    $widget = new widget();
}
// check given widget var...
if (isset($_GET['widget']) && is_numeric($_GET['widget']))
{   // load widget properties
    $widget->loadProperties($db, $_GET['widget']);
}
else
{   // var not set or manipulated...
    alert::draw("danger","$lang[ERROR]", "$lang[VARS_MANIPULATED]","page=widgets","5000");
}

// USER CLICKED ON SAVE
if(isset($_POST['save']))
{     // escape form vars
    $widget->published = $db->quote($_POST['publish']);
    $widget->pageID = $db->quote($_POST['pageID']);
    $widget->widgetType = $db->quote($_POST['widgetType']);
    $widget->sort = $db->quote($_POST['sort']);
    $widget->position = $db->quote($_POST['positions']);
    $widget->marginTop = $db->quote($_POST['marginTop']);
    $widget->marginBottom = $db->quote($_POST['marginBottom']);
    $widget->date_publish = $db->quote($_POST['date_publish']);
    $widget->date_unpublish = $db->quote($_POST['date_unpublish']);
    $widget->widgetTitle = $db->quote($_POST['widgetTitle']);
    $widget->blocked = isset($_POST['mystatus']);

    // if date publish is not set, set it to current datetime
    if (empty($widget->date_publish)) { $widget->date_publish = sys::now(); }

    // save widget state
    if ($widget->save($db) === true)
    {
        alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET] $lang[SETTINGS] $lang[SAVED]", "","1200");
    }
    else
    {
        alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET] $lang[SETTINGS] $lang[NOT_SAVED]", "","2400");
    }

    foreach($_POST as $property=>$value)
    {
        if($property != "save")
        {
            if (isset($_GET['widget']) && is_numeric($_GET['widget']))
            {   // save widget settings
                YAWK\settings::setWidgetSetting($db, $property, $value, $_GET['widget']);
            }
        }
    }
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($widget->name, $lang['WIDGET']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"$lang[WIDGETS]\"> $lang[WIDGETS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-edit&widget=$widget->id\" title=\"$lang[WIDGET_EDIT_SUBTEXT]\"> $lang[EDIT]:&nbsp; <b>$widget->name $lang[WIDGET]</b></a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>

<!-- bootstrap date-timepicker -->
<link type="text/css" href="../system/engines/datetimepicker/css/datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="../system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" >
    $(document).ready(function() {
// load datetimepicker  (start time)
        $('#datetimepicker1').datetimepicker({
            // format: 'yyyy-mm-dd hh:ii:ss'
            format: 'YYYY-MM-DD HH:mm:ss'
        });
// load 2nd datetimepicker (end time)
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });

    }); //]]>  /* END document.ready */
    /* ...end admin jQ controlls  */
</script>
<!-- FORM -->
<form name="form" role="form" action="index.php?page=widget-edit&widget=<?php echo $widget->id; ?>" method="post">
    <div class="row">
        <!-- LEFT -->
        <div class="col-md-4">
            <!-- BASIC WIDGET SETTINGS -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "$lang[COMMON_WIDGET_SETTINGS]"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- WIDGET -->
                    <label for="widgetType"><?php echo $lang['WIDGET']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_NAME']); ?>
                    </label>
                    <select id="widgetType" name="widgetType" class="form-control" readonly>
                        <option value="<?php echo $widget->widgetType; ?>"><?php echo $widget->name; ?></option>
                    </select>
                    <!-- PAGE -->
                    <label for="pageID"><?php echo $lang['ON_PAGE']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_PAGE']); ?>
                    </label>
                    <select id="pageID" name="pageID" class="form-control">
                        <?php
                        $pages = \YAWK\sys::getPages($db);
                        foreach ($pages as $page)
                        {
                            // check, if option needs to be selected
                            if ($widget->pageID == $page['id']){
                                $selectedHtml = " selected";
                            }
                            else { $selectedHtml = ""; }

                            if ($widget->pageID == 0){
                                $allSelected = " selected";
                            }
                            else { $allSelected = ""; }

                            // draw options
                            if (isset($page['id']) && (isset($page['title']))) {
                                echo "<option value=\"".$page['id']."\"$selectedHtml>".$page['title']."</option>";
                            }
                        }
                        // all pages option
                        echo"<option value=\"0\"$allSelected>$lang[ON_ALL_PAGES]</option>";
                        ?>
                    </select>
                    <!-- POSITION -->
                    <label for="positions"><?php echo $lang['AT_POSITION']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_POS']); ?>
                    </label>
                    <select id="positions" name="positions" class="form-control">
                        <option value="<?php echo $widget->position; ?>"><?php echo $widget->position; ?></option>
                        <option value="">-----</option>

                        <?php /* get tpl positions */
                        $i = 0;
                        $position[$i] = array();
                        foreach(template::getTemplatePositions($db) as $position[$i]){
                            echo "<option value=\"".$position[$i]."\">".$position[$i]."</option>";
                            $i++;
                        }
                        ?>
                    </select>

                    <br>
                    <!-- DATE_PUBLISH -->
                    <label for ="datetimepicker1"><?php echo $lang['START_PUBLISH']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_PUBLISH_DATE']); ?></label>
                    <input id="datetimepicker1" name="date_publish" autocomplete="off" class="form-control" value="<?php echo $widget->date_publish; ?>">

                    <!-- DATE_UNPUBLISH -->
                    <label for ="datetimepicker2"><?php echo $lang['END_PUBLISH']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_UNPUBLISH_DATE']); ?></label>
                    <input id="datetimepicker2" name="date_unpublish" autocomplete="off" class="form-control" value="<?php echo $widget->date_unpublish; ?>">
                    <br>
                    <!-- MARGIN TOP -->
                    <label for="marginTop"><?php echo "$lang[MARGIN_TOP] <i><small>$lang[LEAVE_BLANK_FOR_NO_MARGIN]</small></i>"; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_MARGIN_TOP']); ?></label>
                    <input type="text" id="marginTop" class="form-control" placeholder="" name="marginTop" maxlength="11" value="<?php echo $widget->marginTop; ?>">
                    <!-- MARGIN BOTTOM -->
                    <label for="marginBottom"><?php echo "$lang[MARGIN_BOTTOM] <i><small>$lang[LEAVE_BLANK_FOR_NO_MARGIN]</small></i>"; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_MARGIN_BOTTOM']); ?></label>
                    <input type="text" id="marginBottom" class="form-control" name="marginBottom" placeholder="" maxlength="11" value="<?php echo $widget->marginBottom; ?>">
                    <br>
                    <!-- SORTATION -->
                    <label for="sort"><?php echo $lang['SORTATION_ORDER']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_SORTATION_ORDER']); ?></label>
                    <input id="sort" type="text" class="form-control" name="sort" maxlength="6" value="<?php echo $widget->sort; ?>">

                    <!-- NOTE -->
                    <label for ="widgetTitle"><?php echo $lang['NOTE']; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_NOTE']); ?></label>
                    <input id="widgetTitle" name="widgetTitle" class="form-control" value="<?php echo $widget->widgetTitle; ?>">
                    <br>

                    <!-- PUBLISHED / UNPUBLISHED CHECKBOX -->
                    <?php if ($widget->published == "1") { $checkedHtml=" checked"; $value=1; } else { $checkedHtml = ''; $value =0; } ?>
                    <input type="hidden" name="publish" value="0">
                    <input type="checkbox" data-on="<?php echo $lang['ON_'];?>" data-off="<?php echo $lang['OFF_'];?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" id="publish" name="publish" value="1"<?php echo $checkedHtml;?>>
                    <label for="publish">&nbsp;<?php echo "$lang[PUBLISHED]"; ?>
                        <?php echo backend::printTooltip($lang['TT_WIDGET_PUBLISH']); ?></label>


                </div>
            </div>
        </div> <!-- end left col -->

        <!-- RIGHT -->
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "$widget->name $lang[WIDGET] $lang[SETTINGS]"; ?></h3>

                    <button type="submit" id="savebutton" name="save" class="btn btn-success pull-right">
                        <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php echo $lang['WIDGETS_SAVE_BTN']; ?>
                    </button>
                </div>
                <div class="box-body">
                    <!-- MORE WIDGET SETTINGS -->
                    <?php
                    // draw settings (form elements) for this widget
                    $settings = widget::getAllSettingsIntoArray($db, $widget->id);
                    $widget->getWidgetFormElements($db, $settings, $widget->id, $widget->folder, $lang);
                    ?>
                    <br><input type="hidden" name="widgetID" value="<?php echo $widget->id; ?>">
                    <br>

                </div>
            </div>
        </div>
    </div>
</form>