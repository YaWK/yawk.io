<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\sys;
use YAWK\user;

/** @var $db db */
/** @var $lang language */

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
echo backend::getTitle($lang['LOGINS'], $lang['LOGINS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=logins\" title=\"$lang[LOGINS]\"> $lang[LOGINS]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<table style="width:100%;" class="table table-striped table-hover table-responsive" id="table-sort">
    <thead>
    <tr>
        <td style="width:3%;"><strong>&nbsp;</strong></td>
        <td style="width:3%;" class="text-center"><strong><?php echo $lang['ID']; ?></strong></td>
        <td style="width:15%;" class="text-center"><strong><?php echo $lang['DATE']; ?></strong></td>
        <td style="width:14%;" class="text-center"><strong><?php echo $lang['IP']; ?></strong></td>
        <td style="width:15%;" class="text-center"><strong><?php echo $lang['USERNAME']; ?></strong></td>
        <td style="width:10%;" class="text-center"><strong><?php echo $lang['PASSWORD']; ?></strong></td>
        <td style="width:10%;" class="text-center"><strong><?php echo $lang['LOGIN_FROM']; ?></strong></td>
        <td style="width:2%;" class="text-center"><strong><?php echo $lang['FAILED']; ?></strong></td>
        <td style="width:28%;" class="text-center"><strong><?php echo $lang['BROWSER']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
    // check if a user is specified via get param
    if (isset($_GET['user']) && (!empty($_GET['user'])))
    { $user = $_GET['user']; } else { $user = ''; } // if not, show all logins

    $loginData = user::getLoginData($db, $user);
    if (is_array($loginData) && (!empty($loginData)))
    {
        foreach ($loginData as $row)
        {
            if ($row['failed'] === '0')
            {
                $pub = "success"; $pubtext="OK";
                $text = "text-success text-center";
            } else {
                $pub = "danger"; $pubtext = "failed";
                $text = "text-danger text-center";
            }
            if ($row['location'] === "backend"){
                $locationText = "text-info text-center";
            } else {
                $locationText = "text-muted text-center";
            }
            if (isset($row['useragent']) && (!empty($row{'useragent'})))
            {
                $row['useragent'] = sys::getBrowser($row['useragent']);
            }

            echo "<tr class=\"".$text."\" >
                <td class=\"text-center\">
                  <i class=\"label label-$pub\">$pubtext</i></a>&nbsp;</td>
                <td class=\"text-center\">".$row['id']."</td>
                <td>".$row['datetime']."</td>
                <td class=\"".$text."\" class=\"text-center\">".$row['ip']."</td>
                <td>".$row['username']."</td>
                <td class=\"".$text."\">".$row['password']."</td>
                <td class=\"".$locationText."\">".$row['location']."</td>
                <td class=\"".$text."\">".$row['failed']."</td>
                <td class=\"text-center\">".$row['useragent']['name']." <small>".$row['useragent']['version']."</small></td>

              </tr>";
        }
    }

    ?>
    </tbody>
</table>
