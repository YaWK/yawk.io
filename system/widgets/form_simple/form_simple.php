<?PHP
/* JUST A SIMPLE CONTACT FORM */

/* filter GET + POST DATA */
$sent = filter_input(INPUT_GET, 'sent', FILTER_SANITIZE_STRING);
$email_cc = filter_input(INPUT_POST, 'email_cc', FILTER_SANITIZE_STRING);
$email_from = filter_input(INPUT_POST, 'email_from', FILTER_SANITIZE_STRING);
$email_subject = filter_input(INPUT_POST, 'email_subject', FILTER_SANITIZE_STRING);
$email_message = filter_input(INPUT_POST, 'email_message', FILTER_SANITIZE_STRING);

/* get admin email adress from db */
$email_to = "danielretzl@gmail.com";

 if (isset($sent)){
    if ($sent === '1') {
    include '../../classes/email.php';
    YAWK\Email::sendEmail($email_from, $email_to, $email_cc, $email_subject, $email_message);
    exit;
    }   
}
?>

<p id="booking"><br><br><br></p>
<h1>B o o k i n g <small>Kontakt f&uuml;r Veranstalter</small></h1>
Ob Rockkonzert, Clubgig, Hochzeit, Privatfeier, Firmenfest… oder ähnliches - ich freue mich auf Ihre Anfrage - nichts ist unmöglich!! Kontaktieren Sie mich bitte über das Kontaktformular, ich bin mir sicher wir finden den richtigen Musikact für Ihren Anspruch.
<br /><br />

<form method="POST" action="system/widgets/form_simple/form_simple.php?sent=1" class="form-horizontal" id="contact-form">
    <div class="control-group">
        <div class="controls">
            <label class="control-label" for="name">Ihr Name</label>
            <input class="form-control" type="text" name="name" id="name" placeholder="Ihr Name">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="control-label" for="name">Emailadresse</label>
            <input class="form-control" type="text" name="email_from" id="email" placeholder="Ihre Emailadresse">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="email_subject">Buchung:</label>
        <div class="controls">
            <select class="form-control" id="email_subject" name="email_subject">
              <option>Allgemeine Anfrage</option>
              <option>BEngels</option>
              <option>Strike</option>
              <option>Stephan Solo </option>
              <option>Stephan im Duo </option>
            </select>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="control-label" for="email_message">Nachricht</label><br>
            <textarea name="email_message" id="email_message" rows="6" cols="72" 
                class="form-control" placeholder="Schreiben Sie hier Ihre Nachricht...">
            </textarea>
        </div>
        <div class="checkbox" style="margin-left:20px; margin-bottom:10px;">
            <input name="email_cc" id="email_cc" type="checkbox" checked="checked"> Kopie dieser Nachricht an mich senden.
        </div>
    </div>
    <div class="form-actions">
        <input type="hidden" name="save" value="contact">
        <button type="submit" name="send" class="btn btn-success">Nachricht senden</button>
    </div>
</form>
<br /><br /><br /><br />