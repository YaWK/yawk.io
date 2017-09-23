<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['DATABASE'], $lang['SETTINGS']);
echo \YAWK\backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- DATABASE -->
<div class="box">
    <div class="box-body">
        <div class="col-md-10">
            <?php echo "<h4><i class=\"fa fa-database\"></i> &nbsp;$lang[DATABASE]&nbsp;<small>$lang[DATABASE_SUBTEXT]</small></h4>"; ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i id="savebuttonIcon" class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
        </div>
    </div>
</div>
    <div class="row animated fadeIn">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['DATABASE']; ?>  <small><?php echo $lang['DATABASE_SUBTEXT']; ?> </small></h3>
                </div>
                <div class="box-body">
                    <?php
                    // echo "<h2>Language Array</h2><pre>"; echo print_r($lang); echo "</pre>";

                    $dbTables = $db->get_tables();
                    echo "<table id=\"table-sort\" class=\"table table-striped table-hover table-condensed table-responsive table-bordered\">
									<tr class=\"text-bold\"><td>ID</td>
										<td>TABLE</td>
									</tr>";
                    foreach ($dbTables AS $id=>$table)
                    {
                        echo "<tr><td>$id</td><td>$table</td></tr>";
                    }
                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- database settings -->
            <div class="box">
                <div class="box-body">
                    <?php \YAWK\settings::getFormElements($db, $settings, 21, $lang); ?>
                </div>
            </div>
        </div>
    </div>