 <?php
include '../../../dbconnect.php';
include '../../../classes/alert.php';
include '../../../classes/sys.php';
$name		=	$_POST['name'];
$email		=	$_POST['email'];
$now		= 	date("Y-m-d H:i:s");

$name = strip_tags($name);
$email = strip_tags($email);
$name = mysqli_real_escape_string($connection, $name);
$email = mysqli_real_escape_string($connection, $email);

    $sql		=	"INSERT INTO ".$dbprefix."newsletter (date_created, name, email)
					 VALUES('$now', '$name', '$email')";
    mysqli_query($connection,$sql);

    $html		=	'';

    if( mysqli_insert_id($connection) ) {
        // if user is guest, show comment
        $html .= \YAWK\alert::draw("success", "Vielen Dank!", "Deine Emailadresse wurde eingetragen. Ich halte Dich am laufenden!
        &nbsp;<b><i class=\"fa fa-smile-o\"></i></b>");
    }
    else {
        $html .= \YAWK\alert::draw("error", "Entschuldigung!", "Die Daten konnten nicht gespeichert werden, bitte versuch es nochmals.");
    }
    echo $html;
