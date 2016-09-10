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

<a class="btn btn-info" href="index.php?page=dashboard" style="float:right;" >
    <i class="fa fa-backward"></i> &nbsp;<?php print $lang['DASHBOARD']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="3%"><strong>ID</strong></td>
        <td width="15%"><strong>Datum</strong></td>
        <td width="14%" class="text-center"><strong>IP</strong></td>
        <td width="15%"><strong>Username</strong></td>
        <td width="10%"><strong>Password</strong></td>
        <td width="10%"><strong>Location</strong></td>
        <td width="2%" class="text-center"><strong>Failed</strong></td>
        <td width="28%" style="text-align: center;"><strong>UserAgent</strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP
    global $dbprefix, $connection;
    $res = mysqli_query($connection, "SELECT * FROM ".$dbprefix."logins ORDER BY id DESC");

    while($row = mysqli_fetch_assoc($res)){

        if ($row['failed'] === '0')
        {
            $pub = "success"; $pubtext="OK";
            $text = "text-success";
        } else {
            $pub = "danger"; $pubtext = "failed";
            $text = "text-danger";
        }
        if ($row['location'] === "backend"){
            $locationText = "text-info";
        } else {
            $locationText = "text-muted";
        }

        echo "<tr class=\"".$text."\" >
                <td style=\"text-align:center;\">
                  <i class=\"label label-$pub\">$pubtext</i></a>&nbsp;</td>
                <td style=\"text-align:center;\">".$row['id']."</td>
                <td>".$row['datetime']."</td>
                <td class=\"".$text."\" style=\"text-align:center;\">".$row['ip']."</td>
                <td>".$row['username']."</td>
                <td class=\"".$text."\">".$row['password']."</td>
                <td class=\"".$locationText."\">".$row['location']."</td>
                <td class=\"".$text."\">".$row['failed']."</td>
                <td style=\"text-align:center;\">".$row['useragent']."</td>

              </tr>";
    }
    ?>
    </tbody>
</table>
