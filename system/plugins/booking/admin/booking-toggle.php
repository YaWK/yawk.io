<?PHP
include '../system/plugins/booking/classes/booking.php';
$booking = new YAWK\PLUGINS\BOOKING\booking();

if (isset($_GET['id'])){
    $booking->confirmed = $booking->getProperty($db, $_GET['id'], "confirmed");
    $booking->id = $_GET['id'];

    if (isset($_GET['invite']) && ($_GET['invite'] === '1')){
        $booking->email = $booking->getProperty($db, $booking->id, "email");
        $booking->name = $booking->getProperty($db, $booking->id, "name");
        $booking->inviteUser($db, $booking->id, $booking->email, $booking->name);
    }
    if (isset($_GET['success']) && ($_GET['success'] === '1')){
        $booking->success = 1;
    }
    if (isset($_GET['ban'])){
        $booking->email = $booking->getProperty($db, $booking->id, "email");
        $booking->toggleBan($db, $booking->id, $booking->email);
        \YAWK\backend::setTimeout("index.php?plugin=booking", 0);
    }
    if (isset($_GET['outdated'])){
        $booking->toggleOutdated($db, $booking->id);
        \YAWK\backend::setTimeout("index.php?plugin=booking", 0);
    }
    if (isset($_GET['toggle']) && ($_GET['toggle'] === '1')){
        // check status and toggle it
        if ($booking->confirmed === '1') {
            $booking->confirmed = 0;
        } else {
            $booking->confirmed = 1;
        }
        if ($booking->success === '1'){
            $booking->success = 0;
        }

        if ($booking->toggleOffline($db, $booking->id, $booking->confirmed, $booking->success)) {
            \YAWK\backend::setTimeout("index.php?plugin=booking&pluginpage=booking-edit&id=$booking->id", 0);
        } else {
            print \YAWK\alert::draw("danger", "Error", "Could not toggle booking status.","",4200);
        }
    }
}
else { $booking->id = 0; }



