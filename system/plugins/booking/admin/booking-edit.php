<?php
include '../system/plugins/booking/classes/booking.php';
// get db vars

// generate new booking object
$booking = new \YAWK\PLUGINS\BOOKING\booking();

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['BOOKING'], $lang['BOOKING_DETAILS']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Pages\"> Plugins</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=booking\" title=\"Booking\"> Booking</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

// form sent: prepare vars and add into db
if (isset($_POST['create'])){
    if (isset($_GET['id'])){
        $booking->id = $db->quote($_GET['id']);
    }
    if (isset($_POST['income'])){
        $booking->income = $db->quote($_POST['income']);
        // $booking->success = 1;
    } else { $booking->income = 0;
             $booking->success = 0;
    }
    if (isset($_POST['grade'])){
        $booking->grade = $db->quote($_POST['grade']);
    } else { $booking->grade = '';
    }
    if (isset($_POST['comment'])){
        $booking->comment = $db->quote($_POST['comment']);
    } else { $booking->comment = '';
    }
    if (isset($_POST['date_wish'])){
        $booking->date_wish = $db->quote($_POST['date_wish']);
    }
    if (isset($_POST['date_alternative'])){
        $booking->date_alternative = $db->quote($_POST['date_alternative']);
    }
    if(!$booking->save($db)){
        \YAWK\alert::draw("warning", "Achtung", "Der Termin konnte nicht gespeichert werden.","",4200);
    }
}

// check _GET var
if (isset($_GET['id'])){
    $booking->loadProperties($db, $_GET['id']);
    // get logic, a lot of if x then y....
    $year = date('Y');
    // set to_do integer to str
    if ($booking->todo === '0'){
        $booking->todo = 'keine Angabe';
    }
    if ($booking->todo === '1'){
        $booking->todo = "Solo Termin";
    }
    if ($booking->todo === '2'){
        $booking->todo = "Dreier (MMF)";
    }
    if ($booking->todo === '3'){
        $booking->todo = "Dreier (FFM)";
    }
    if ($booking->todo === '4'){
        $booking->todo = "Handjob / Blowjob Quickie";
    }
    if ($booking->todo === '5'){
        $booking->todo = 'keine Angabe';
    }
    if ($booking->ip === '::1') {
        $booking->ip = "::1 (localhost)";
    }
    $splitDate_created = \YAWK\sys::splitDate($booking->date_created);
    $splitDate_wish = \YAWK\sys::splitDate($booking->date_wish);
    $splitDate_alternative = \YAWK\sys::splitDate($booking->date_alternative);
    // date created
    $year_created = $splitDate_created['year'];
    $day_created = $splitDate_created['day'];
    $month_created = $splitDate_created['month'];
    $time_created = $splitDate_created['time'];
    // date wish
    $year_wish = $splitDate_wish['year'];
    $day_wish = $splitDate_wish['day'];
    $month_wish = $splitDate_wish['month'];
    $time_wish = $splitDate_wish['time'];
    // date alternative
    $year_alt = $splitDate_alternative['year'];
    $day_alt = $splitDate_alternative['day'];
    $month_alt = $splitDate_alternative['month'];
    $time_alt = $splitDate_alternative['time'];
    // make dates pretty
    $prettydate_created = "$day_created.$month_created $year, $time_created";
    $prettydate_wish = "$day_wish.$month_wish um $time_wish Uhr";
    $prettydate_alternative = "$day_alt.$month_alt, $time_alt Uhr";

    // if alternative is zero, make it empty for a better tbl view experience
    if ($prettydate_alternative === "0.00, 00:00 Uhr"){
        $prettydate_alternative = 'keine Angabe';
    }
    if ($booking->cut === '1'){
        $cutHtml = "checked";
    }
    else {
        $cutHtml = "";
    }
    if ($booking->invited === '1'){
        $inviteHtml = "<a class=\"btn btn-success\" href=\"index.php?plugin=booking&pluginpage=booking-toggle&id=$booking->id&invite=1\" style=\"float:right;\">
        <i class=\"fa fa-envelope-o\"></i> &nbsp;Invitation Email sent</a>";
    }
    else {
        $inviteHtml = "<a class=\"btn btn-warning\" href=\"index.php?plugin=booking&pluginpage=booking-toggle&id=$booking->id&invite=1\" style=\"float:right;\">
        <i class=\"fa fa-envelope-o\"></i> &nbsp;Send Invitation Email</a>";
    }
    if ($booking->confirmed === '1'){
        $confirmedHtml = "<span class='text-success'>Termin fixiert</span>";
        $confirmedIcon = "<i class='fa fa-check'></i>";
    } else {
        $confirmedHtml = "<span class='text-warning'>nicht fixiert</span>";
        $confirmedIcon = "<i class='fa fa-times'></i>";
    }
    if ($booking->success === '1'){
        $confirmedHtml = "<span class='text-info'>erledigt</span>";
        $confirmedIcon = "<i class='fa fa-trophy'></i>";
    }
    if ($booking->outdated === '1'){
        $confirmedHtml = "<span class='text-inverse'>outdated</span>";
    }
    if (!isset($booking->referer)) { $booking->referer = ""; }

    if ($booking->uid !== '0' && $booking->gid !== '0'){
        $filename = '../media/images/users/user_'.$booking->name.'.jpg';
        if (file_exists($filename)){
            $imgHtml = "<img src=\"$filename\" width=\"180\" class=\"img-thumbnail\">";
        }
        else {
            $imgHtml = "<i class=\"fa fa-user fa-5x\"></i>";
        }
    }
    else {
        $imgHtml = "<i class=\"fa fa-user fa-5x\"></i>";
    }
?>

    <div class="box box-default">
    <div class="box-body">
    <div class="row">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item"><h4>Details <small>zu diesem Terminvorschlag</small></h4></li>
                <li class="list-group-item"><h4><strong><?php echo $booking->name; ?></strong> hat einen Terminwunsch am <strong><?php echo $prettydate_wish; ?></strong></h4></li>
                <li class="list-group-item"><i class="fa fa-envelope"></i> &nbsp;<strong><?php echo "<a href=\"mailto:$booking->email\">$booking->email</a>"; ?></strong></li>
                <li class="list-group-item"><i class="fa fa-phone"></i> &nbsp;<strong><?php echo $booking->phone; ?></strong></li>
                <li class="list-group-item"><i class="fa fa-group"></i> &nbsp;<strong><?php echo $booking->todo; ?></strong></li>
                <li class="list-group-item"><i class="fa fa-clock-o"></i> &nbsp;<strong><?php echo $prettydate_alternative; ?></strong> <small>[alternativ]</small></li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item"><i class="fa fa-comments-o"></i> &nbsp;<strong><?php echo $booking->text; ?></strong></li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item"><h6>gesendet von <strong>&nbsp;<?php echo $booking->name; ?>&nbsp;</strong>
                    am <?php echo $prettydate_created; ?> via IP Adresse <?php echo $booking->ip; ?><br><small>
                    <i><?php echo $booking->useragent; ?></i>
                   <br><?php echo $booking->referer; ?></small></h6></li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <form class="form-inline" method="post" action="index.php?plugin=booking&pluginpage=booking-edit&id=<?PHP echo $booking->id; ?>">
                        <label for="cut"><i class="fa fa-scissors"></i>&nbsp;</label>
                        <input type="checkbox" id="cut" name="cut" class="form-control" value="1" <?PHP echo $cutHtml; ?>>&nbsp;
                        <label for="income">&euro;&nbsp;</label>
                        <input type="text" value="<?PHP echo $booking->income;?>" size="5" class="form-control" placeholder="150" id="income" name="income">&nbsp;&nbsp;&nbsp;
                        <label for="income"><i class="fa fa-line-chart"></i>&nbsp; </label>
                        <select class="form-control" name="grade" id="grade">
                            <option value="0" selected disabled>&nbsp;</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>&nbsp;&nbsp;&nbsp;
                        <label for="comment"><i class="fa fa-commenting-o"></i></label>
                        <textarea name="comment" id="comment" class="form-control" cols="46" rows="2"><?PHP echo $booking->comment;?></textarea>
                        <br>
                        </li>
                <li class="list-group-item">
                    <label for="date_wish">Datum &auml;ndern</label>
                    <input type="text" class="form-control" name="date_wish" size="10" id="date_wish" value="<?PHP echo $booking->date_wish;?>"><br>
                    <label for="date_alternative">Alternativdatum: </label>
                    <input type="text" class="form-control" name="date_alternative" size="10" id="date_alternative" value="<?PHP echo $booking->date_alternative;?>">
                        <!-- SAVE BUTTON -->
                        <input id="savebutton" class="btn btn-success" type="submit" name="create" style="margin-left:14px;" value="<?PHP echo $lang['SAVE']; ?>">
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item"><?php echo $imgHtml; ?></li>
            </ul>

            <ul class="list-group">
                <li class="list-group-item"><?PHP echo $confirmedIcon; ?>
                    &nbsp;Status: <h3 style="margin-top:-4%; margin-left: 50%;"><?php echo $confirmedHtml; ?></h3>

                <li class="list-group-item"><i class="fa fa-trophy"></i>
                    &nbsp;Success: <h3 style="margin-top:-4%; margin-left: 50%;"><?php echo $booking->success; ?></h3>
                </li>
                <li class="list-group-item"><i class="fa fa-money"></i>
                    &nbsp;Earned: <h3 style="margin-top:-4%; margin-left: 50%;">&euro;&nbsp;<?php echo $booking->income; ?></h3>
                </li>
                <li class="list-group-item"><i class="fa fa-line-chart"></i>
                    &nbsp;Vote: <h3 style="margin-top:-4%; margin-left: 50%;"><?php echo $booking->grade; ?></h3>
                </li>
                <li class="list-group-item"><i class="fa fa-heart"></i>
                    &nbsp;Visits:<h3 style="margin-top:-4%; margin-left: 50%;"><?php echo $booking->countVisits($db, $booking->email); ?></h3>
                </li>
                <li class="list-group-item"><i class="fa fa-commenting-o"></i>
                    &nbsp;Comment: <h4 style="margin-top:-4%; margin-left: 50%;"><?php echo $booking->comment; ?></h4>
                </li>
            </ul>
            <?php echo $inviteHtml; ?>
            <a class="btn btn-info" href="index.php?plugin=booking&pluginpage=booking-toggle&toggle=1&id=<?PHP echo $booking->id; ?>&success=1" style="float:right;">
            <i class="fa fa-trophy"></i> &nbsp;<?php print $lang['BOOKING_TOGGLE']; ?></a>
            <a class="btn btn-default" href="index.php?plugin=booking" style="float:right;">
            <i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>
        </div>
    </div>
    </div>
    </div>
<?PHP
}

?>