<!-- bootstrap date-timepicker -->
<link type="text/css" href="../system/engines/datetimepicker/css/datetimepicker.min.css" rel="stylesheet"/>
<script type="text/javascript" src="../system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- init datetimepicker -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });
    });//]]>  /* END document.ready */
</script>
<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/tourdates/language/");
}

include '../system/plugins/tourdates/classes/tourdates.php';

/* if form is sent... */
if (isset($_POST['date'])) {
    $tourdates = new \YAWK\PLUGINS\TOURDATES\tourdates();
    $tourdates->date = filter_input(INPUT_POST, 'date');
    $tourdates->band = filter_input(INPUT_POST, 'band');
    $tourdates->venue = filter_input(INPUT_POST, 'venue');
    $tourdates->fburl = filter_input(INPUT_POST, 'fburl');

    if (!$res = $tourdates->create($db, $tourdates->date, $tourdates->band, $tourdates->venue, $tourdates->fburl))
    {   // q failed
        print \YAWK\alert::draw("danger", "Error", "Could not add event. Maybe there is a database error. We're sorry!", "plugin=tourdates","4200");
        exit;
    }
    else
    {   //
        \YAWK\backend::setTimeout("index.php?plugin=tourdates", 0);
    }
}


// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['TOUR_DATES'], $lang['TOUR_DATES_ADD']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?plugin=tourdates\" title=\"$lang[TOUR_DATES]\"> $lang[TOUR_DATES]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=tourdates&pluginpage=tourdates-new\" title=\"$lang[ADD]\"> $lang[ADD]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<div class="box box-default">
    <div class="box-body">

    <!-- FORM -->
    <form role="form" class="form" action="index.php?plugin=tourdates&pluginpage=tourdates-new&addgig=1" method="post">
        <!-- PUBLISH DATE -->
        <label for="datetimepicker1"><?php print $lang['DATE']; ?>:&nbsp;
            <input class="form-control" id="datetimepicker1" data-date-format="yyyy-mm-dd hh:mm:ss" type="text"
                   name="date" maxlength="19">
        </label>
        <!-- BAND -->
        <label for="band"><?php print $lang['TOUR_BAND']; ?>&nbsp;
            <input type="text" id="band" size="28" name="band" class="form-control" maxlength="128"
                   placeholder="<?php print $lang['TOUR_BAND_INPUT']; ?>"/>
        </label>
        <!-- VENUE -->
        <label for="venue"><?php print $lang['TOUR_VENUE']; ?>&nbsp;
            <input type="text" id="venue" size="28" name="venue" class="form-control" maxlength="128"
                   placeholder="<?php print $lang['TOUR_VENUE_INPUT']; ?>"/>
        </label>
        <!-- FB LINK -->
        <label for="fburl"><?php print $lang['TOUR_FBLINK']; ?>&nbsp;
            <input type="text" id="fblink" size="28" name="fburl" class="form-control" maxlength="255"
                   placeholder="<?php print $lang['TOUR_FBLINK']; ?>"/>
        </label>
        <!-- SUBMIT BUTTON -->
        <input type="submit" class="btn btn-success" value="<?php print $lang['TOUR_DATES_ADD']; ?>"/>
    </form>
    </div>
</div>