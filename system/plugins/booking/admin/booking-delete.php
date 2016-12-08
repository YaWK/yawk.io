<?PHP
include '../system/plugins/booking/classes/booking.php';
$booking = new \YAWK\PLUGINS\BOOKING\booking();
$booking->loadProperties($db, $db->quote($_GET['id']));

if ($_GET['delete'] === '1') {
    if ($booking->delete($db)) {
        print \YAWK\alert::draw("success", "The Booking '".$_GET['id']."' was deleted", "delete successful","index.php?plugin=booking",4200);
    }
}
