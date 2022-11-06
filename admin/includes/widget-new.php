<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\widget;

/** @var $db db */
/** @var $lang language */

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['WIDGET+'], $lang['WIDGETS+_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"$lang[WIDGETS]\"> $lang[WIDGETS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-new\" title=\"".$lang['WIDGET+']."\"> ".$lang['WIDGET+']."</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */


// DELETE? if(!isset($_POST['widgetType'])){
?>
    <div class="row">
        <div class="col-md-5">
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header with-border"><h3 class="box-title"><?php echo $lang['WIDGET+']; ?></h3></div>
                    <br>
                    <form action="index.php?page=widgets&add=1" role="form" method="post">
                        <label for="widgetType"><?php echo $lang['CREATE']; ?>:</label>
                        <select id="widgetType" name="widgetType" class="form-control">
                            <option value="empty" name="empty" disabled selected aria-disabled="true" aria-selected="true"><?php echo $lang['SELECT_WIDGET']; ?></option>
                            <?php
                            foreach(YAWK\widget::getWidgetsArray($db) as $widget){
                                echo "<option value=\"".$widget['id']."\"";

                                if (isset($_POST['widget'])) {
                                    if($_POST['widget'] === $page['id']){
                                        echo " selected=\"selected\"";
                                    }
                                    else if($widget->widget === $widget['id'] && !$_POST['widget']){
                                        echo " selected=\"selected\"";
                                    }
                                }
                                echo ">".$widget['name']."</option>";
                            }
                            ?>
                        </select>
                        <label for="pageID"><?php echo $lang['ON_PAGE']; ?>:
                            <?php echo backend::printTooltip($lang['TT_WIDGET_PAGE']); ?></label>
                        <select id="pageID" name="pageID" class="form-control">
                            <option value="0"><?php echo $lang['ON_ALL_PAGES']; ?></option>
                            <?php
                            foreach(YAWK\sys::getPages($db) as $page){
                                echo "<option value=\"".$page['id']."\"";

                                if (isset($_POST['pageID'])) {
                                    if($_POST['pageID'] === $page['id']){
                                        echo " selected=\"selected\"";
                                    }
                                    else if($page->page === $page['id'] && !$_POST['page']){
                                        echo " selected=\"selected\"";
                                    }
                                }
                                echo ">".$page['title']."</option>";
                            }
                            ?>
                        </select>
                        <label for="position"><?php echo $lang['AT_POSITION']; ?>
                            <?php echo backend::printTooltip($lang['TT_WIDGET_POS']); ?></label>
                        <select id="position" name="positions" class="form-control">
                            <option value=""></option>
                            <?php
                            $i = 0;
                            foreach(YAWK\template::getTemplatePositions($db) as $positions){
                                $position[] = $positions;
                                echo "<option value=\"".$position[$i]."\"";

                                if (isset($_POST['positions'])) {
                                    if($_POST['0'] === $position['positions']){
                                        echo " selected=\"selected\"";
                                    }
                                    else if($position->positions === $position['positions'] && !$_POST['positions']){
                                        echo " selected=\"selected\"";
                                    }
                                }
                                echo ">".$position[$i]."</option>";
                                $i++;
                            }
                            ?>
                        </select><br>
                        <input type="submit" class="btn btn-success pull-right"  value="<?php echo $lang['CREATE']; ?>">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header with-border"><h3 class="box-title"><?php echo $lang['WIDGET']." ".$lang['OVERVIEW']; ?></h3></div>
                    <div class="box-body">
                        <?php

                        $widgetTypes = \YAWK\widget::getAllWidgetTypes($db);
                        if (isset($widgetTypes) && (is_array($widgetTypes)))
                        {   // draw widget types list data
                            foreach ($widgetTypes as $widget)
                            {
                                // check widget contains language files
                                if (is_dir('../system/widgets/'.$widget['folder'].'/language/'))
                                {   // inject (add) language tags to core $lang array
                                    $widgetLang = \YAWK\language::inject($lang, "../system/widgets/".$widget['folder']."/language/");
                                }

                                // walk through widget list
                                echo '<div class="box box-default">';
                                echo '<div class="box-header with-border"><h3 class="box-title"><b>'.$widget['name'].'</b></h3>
                            <br><span class="text-muted">'.$widget['description'].'</span>';
                                if ($widget['status'] != 1) { echo 'WIDGET IS DISABLED'; }
                                echo'<small><span class="pull-right text-muted">ID: '.$widget['id'].'</span></small>
                            </div>';

                                echo '<div class="box-body">';
                                echo '<div class="row">';

                                if (!empty($widget['icon']))
                                {
                                    if (!empty($widget['color'])){ $colorMarkup = 'color:#'.$widget['color'].';'; }
                                    else { $colorMarkup='color:#666'; }
                                    echo '<div class="col-md-4 text-center" style="top:-20px;">';
                                    echo '<h1><i class="'.$widget['icon'].'" style="vertical-align:middle;'.$colorMarkup.'"></i></h1>';
                                }
                                else {
                                    echo '<div class="col-md-4 text-center">';
                                }

                                echo '</div>';
                                echo '<div class="col-md-8">';
                                // RIGHT COL, extended info + help
                                if (!empty($widgetLang['WIDGET_INFO']))
                                {
                                    echo $widgetLang['WIDGET_INFO'];
                                }
                                else
                                {
                                    echo '<small class="text-muted">'.$lang['WIDGET_INFO_MISSING'].'<br><small>add WIDGET_INFO to system/widgets/'.$widget['folder'].'/language/</small></small>';
                                }
                                echo '</div>';
                                echo '</div>';

                                echo '</div>';
                                echo '</div>';
                            }
                        } // end if widgetTypes array is set
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
// DELETE? }
?>