<script type="text/javascript" src="system/plugins/booking/js/booking.js"></script>
<script type="text/javascript" src="system/engines/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="system/engines/jquery/messages_de.min.js"></script>

<script type="text/css">
    input.field {
        color: #B94A48;
        background-color: #F2DEDE;
        border-color: #B94A48;
    }
</script>
<?php
include 'classes/booking.php';
// generate new booking item
$booking = new YAWK\PLUGINS\BOOKING\booking();
// if form is sent
if (isset($_POST['sent']) && $_POST['sent'] === '1'){
    // execute create method
    $booking = $booking->create($db);
    // thank you page...
    echo "<div style='text-align: center; margin-top: 20%; margin-bottom: 600px;'><h1>Thank you <small>for your booking...</small></h1>
          <p>We will get in contact with you soon! <br>
            <br><a href=\"index.html\">Back to Home Page</a></p></div>";

}
else {
    // draw title + form -- FRONTEND --
    echo "<h1><i class=\"fa fa-envelope-o\"></i> &nbsp;Contact <small>feel free to place your booking...</small></h1><hr>";
    echo $booking = $booking->getFrontendForm();
}
?>
