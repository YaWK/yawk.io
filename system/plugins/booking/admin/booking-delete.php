<?PHP
include '../system/plugins/booking/classes/booking.php';
$booking = new \YAWK\PLUGINS\BOOKING\booking();
$booking->loadProperties($db->quote($_GET['id']));

if ($_GET['delete'] === '1') {
    if ($booking->delete($db)) {
        print \YAWK\alert::draw("success", "Erfolg!", "Der Termin " . $_GET['id'] . " wurde gel&ouml;scht!","index.php?plugin=booking",4200);
    }
}
