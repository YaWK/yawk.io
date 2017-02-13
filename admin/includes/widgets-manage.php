<?php
/**
 * Copyright (C) Daniel Retzl
 */

// ADD WIDGET
if (isset($_GET['add']) && ($_GET['add'] === "1"))
{   // prepare vars
    $pageID = $db->quote($_POST['pageID']);
    $widgetType = $db->quote($_POST['widgetType']);
    $positions = $db->quote($_POST['positions']);
    $date_publish = \YAWK\sys::now();

    $newWidgetID = YAWK\widget::create($db, $widgetType, $pageID, $positions, $date_publish);
    if (is_int($newWidgetID) || (is_numeric($newWidgetID)))
    {    // success
        print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET_CREATE_OK]", "page=widget-edit&widget=$newWidgetID", 800);
    }
    else
    {   // throw error
        print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET_CREATE_FAILED]", "", 5800);
    }
}

// DELETE WIDGET
if (isset($_GET['del']) && ($_GET['del'] === "1"))
{
    if (!isset($widget))
    {   // create new widget obj
        $widget = new YAWK\widget();
    }
    if (isset($_GET['widget']) && (isset($_GET['delete']) && ($_GET['delete'] == "true")))
    {   // delete widget
        if($widget->delete($db, $_GET['widget']))
        {   // delete successful
            YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET] $lang[ID]: ".$_GET['widget']." $lang[DELETED]","","800");
        }
        else
        {   // q failed, throw error
            \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET_DEL_FAILED] $lang[WIDGET] $lang[ID]: ".$_GET['widget']."","","5800");
        }
    }
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        } );
    } );
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['WIDGET_MANAGER'], $lang['WIDGET_MANAGER_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"$lang[WIDGETS]\"> $lang[WIDGETS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-manager\" title=\"$lang[WIDGET_MANAGER]\"> $lang[WIDGET_MANAGER]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<div class="box box-default">
    <div class="box-body">
        <a class="btn btn-success pull-right" title="<?php $lang['WIDGET+']; ?>" href="index.php?page=widget-new">
            <i class="glyphicon glyphicon-download-alt"></i> &nbsp;&nbsp;<?php print $lang['WIDGET_INSTALL']; ?></a>

        <table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
            <thead>
            <tr>
                <td width="5%" class="text-center"><strong><?php echo "$lang[STATUS]"; ?></strong></td>
                <td width="5%" class="text-center"><strong><?php echo "$lang[ID]"; ?></strong></td>
                <td width="20%"><strong><?php echo "$lang[WIDGET]"; ?></strong></td>
                <td width="60%"><strong><?php echo "$lang[DESCRIPTION]"; ?></strong></td>
                <td width="10%" class="text-center"><strong><?php echo "$lang[ACTIONS]"; ?></strong></td>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($res = $db->query("SELECT * FROM {widget_types} ORDER BY name"))
            {
                while($row = mysqli_fetch_assoc($res))
                {
                    if ($row['status']==1)
                    {
                        $pub = "success"; $pubtext="$lang[ACTIVE]";
                    }
                    else
                        {
                            $pub = "danger"; $pubtext="$lang[INACTIVE]";
                        }

                    echo "<tr>
                <td class=\"text-center\"><i class=\"label label-$pub\">$pubtext</i></td>
                <td class=\"text-center\">".$row['id']."</td>
                <td><a href=\"index.php?page=widget-edit&widget=".$row['id']."\"><div style=\"width:100%\">".$row['name']."<br></div></a>
                <small>system/widgets/<b>".$row['folder']."</b></small>
                </td>
                
                <td>...</td>
                <td class=\"text-center\">

                <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"".$lang['WIDGET']." &laquo; $row[name] &raquo; ".$lang['DELETE']."?\"
                   title=\"$lang[DELETE]\" href=\"index.php?page=widgets&del=1&widget=$row[id]&delete=true\">
                </a>
                </td>
              </tr>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>