<?php
/* draw Title on top */
YAWK\backend::getTitle($lang['LOGINS'], $lang['LOGINS_SUBTEXT']);
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
echo \YAWK\backend::getTitle($lang['LOGINS'], $lang['LOGINS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=logins\" title=\"Logins\"> Logins</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="3%" class="text-center"><strong>ID</strong></td>
        <td width="15%"><strong>Datum</strong></td>
        <td width="14%" class="text-center"><strong>IP</strong></td>
        <td width="15%" class="text-center"><strong>Username</strong></td>
        <td width="10%" class="text-center"><strong>Password</strong></td>
        <td width="10%" class="text-center"><strong>Login from</strong></td>
        <td width="2%" class="text-center"><strong>Failed</strong></td>
        <td width="28%" class="text-center"><strong>Browser</strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP
    // check if a user is specified via get param
    if (isset($_GET['user']) && (!empty($_GET['user'])))
    { $user = $_GET['user']; } else { $user = ''; } // if not, show all logins

    foreach (\YAWK\user::getLoginData($db, $user) as $row)
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
            $row['useragent'] = \YAWK\sys::getBrowser($row['useragent']);
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
    ?>
    </tbody>
</table>
