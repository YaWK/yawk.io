<?php
session_start();
if(isset($_SESSION)) {
    if (isset($_SESSION['uid']) && (!empty($_SESSION['uid']))) {
        // include db connection
        include '../../../classes/db.php';
        $db = new \YAWK\db();
        // escape var
        $request = $db->quote($_SESSION['uid']);
        // do update query: block user
        $sql = mysqli_query($db, "UPDATE {users} SET terminatedByUser = 1 WHERE id = '" . $request . "'");
        if ($sql) {
            // set user offline in db
            if (!$res = mysqli_query($db, "UPDATE {users}
                               SET online = '0'
                               WHERE id = '" . $request . "'")) {
                print \YAWK\alert::draw("danger", "Fehler", "User konnte nicht korrekt ausgeloggt werden.", "", "");
                echo "Es tut mir leid, anscheinend wurdest Du nicht korrekt ausgeloggt. Bitte versuch es nochmal.";
                die; // something went wrong when updating db
            } else {
                echo "true";
                die; // user terminated + logged out successfully
            }
        } //
        else {
            echo "Es tut mir leid, Dein Account konnte nicht deaktiviert werden. Bitte versuch es nochmal.";
        }
        echo "SORRY! it looks like... IF: we got a problem here";
        die;
    } else {
        echo "Etwas stimmt nicht. Du bist offenbar nicht richtig eingeloggt. Bitte versuch Dich nochmal einzuloggen.";
        die;
    }
}
else {
    echo "Es ist keine Session aktiv. Bitte versuch Dich nochmal einzuloggen.";
}